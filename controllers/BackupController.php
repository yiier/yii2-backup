<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2015/6/29 19:43
 * description:
 */
namespace yiier\backup\controllers;

use yii\console\Controller;
use yiier\backup\helpers\MysqlBackup;
use Yii;

class BackupController extends Controller
{

    public function init()
    {
        parent::init();
        Yii::$app->set('mailer', [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => Yii::$app->setting->get('smtpHost'),
                'username' => Yii::$app->setting->get('smtpUser'),
                'password' => Yii::$app->setting->get('smtpPassword'),
                'port' => Yii::$app->setting->get('smtpPort'),
                // 'mail' => Yii::$app->setting->get('smtpMail'), // 显示地址
                'encryption' => 'tls',
            ],
        ]);
    }

    public function sendEmail($sqlFile)
    {

        return \Yii::$app->mailer->compose('backup')
            ->setFrom([\Yii::$app->setting->get('smtpUser') => Yii::$app->setting->get('siteName') . '机器人'])
            ->setTo(Yii::$app->params['backupEmail'])
            ->setSubject('数据库定时备份系统-' . Yii::$app->setting->get('siteName'))
            ->attach($sqlFile)
            ->send();
    }

    public function actionIndex()
    {
        $sql = new MysqlBackup();
        $tables = $sql->getTables();
        \Yii::info('数据库备份失败', 'backups');
        if (!$sql->StartBackup()) {
            //render error
            \Yii::info('数据库备份失败', 'backup');
            die;
        }

        foreach ($tables as $tableName) {
            $sql->getColumns($tableName);
        }

        foreach ($tables as $tableName) {
            $sql->getData($tableName);
        }
        $sqlFile = $sql->EndBackup();

        $this->sendEmail($sqlFile);
        \Yii::info('数据库备份成功', 'backup');
    }
}
