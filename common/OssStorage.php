<?php

namespace aliyunoss\common;

use tpext\builder\inface\Storage;
use tpext\builder\common\model\Attachment;
use OSS\OssClient;
use UnexpectedValueException;

class OssStorage implements Storage
{
    /**
     * Undocumented function
     *
     * @param Attachment $attachment
     * @return string url
     */
    public function process($attachment)
    {
        $config = Module::getInstance()->getConfig();

        $accessKeyId = $config['access_key_id'];
        $accessKeySecret = $config['access_key_secret'];
        $endpoint = $config['endpoint'];
        $bucketName = $config['bucket_name'];

        if (empty($accessKeyId) || empty($accessKeySecret) || empty($endpoint) || empty($bucketName)) {
            trace('阿里云Oss配置有误');
            $this->delete($attachment);
            return '';
        }

        try {
            $bucketExists = false;
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $bucketListInfo = $ossClient->listBuckets();
            $bucketList = $bucketListInfo->getBucketList();

            foreach ($bucketList as $bu) {
                if ($bu->getName() == $bucketName) {
                    $bucketExists = true;
                    break;
                }
            }

            if (!$bucketExists) { //存储空间不存在，创建
                $ossClient->createBucket($bucketName, OssClient::OSS_ACL_TYPE_PUBLIC_READ);
            }
        } catch (\Throwable $e) {
            trace('阿里云OssClient初始化失败');
            trace($e->__toString());
            $this->delete($attachment);
            return '';
        }

        try {
            $name = preg_replace('/^.+?\/([^\/]+)$/', '$1', $attachment['url']); //获取带后缀的文件名
            $res = $ossClient->uploadFile($bucketName, $name, '.' . $attachment['url']);

            if ($res && isset($res['oss-request-url'])) {
                $ossUrl = $res['oss-request-url'];
                $ossUrl = '//' . preg_replace('/^https?:\/\//', '', $ossUrl); //去掉http协议头，以//开头
                $attachment['url'] = $ossUrl;
                $attachment->save();
                return $ossUrl;
            } else {
                throw new UnexpectedValueException('未知错误');
            }
        } catch (\Throwable $e) {
            trace('阿里云Oss文件上传失败');
            trace($e->__toString());
            $this->delete($attachment);
            return '';
        }

        return '';
    }

    /**
     * OSS操作失败，删除数据库已保存的记录和已上传的文件
     *
     * @param Attachment $attachment
     * @return boolean
     */
    private function delete($attachment)
    {
        $res1 = Attachment::where('id', $attachment['id'])->delete();
        $res2 = @unlink('.' . $attachment['url']);

        return $res1 && $res2;
    }
}
