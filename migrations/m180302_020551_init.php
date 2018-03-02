<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Class m180302_020551_init
 */
class m180302_020551_init extends Migration
{
    public function init() {
        $this->db = 'db';
        parent::init();
    }
    public function tableOptions(){
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        return $tableOptions;
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // User group
        $this->createTable('res_group',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->comment('Group name'),
            'code'=>$this->string(5)->comment('Group code'),
            //
            'create_uid' => $this->integer(), // Created by
            'create_date' =>$this->timestamp()->defaultValue(null), // Created on
            'write_uid'=> $this->integer(), // Last Updated by
            'write_date' => $this->timestamp()->defaultValue(null), // Last Updated on
        ],$this->tableOptions());
        
        $this->batchInsert('res_group', ['id','name'], [
            [1,'ฝ่ายบริหาร'],
            [2,'ฝ่ายบัญชี'],
            [3,'ฝ่ายทะเบียนยา'],
            [4,'ฝ่ายผลิต'],
            [5,'ฝ่ายจัดซื้อ'],
            [6,'ฝ่ายวิศวกรรม'],
            [7,'ฝ่ายวิชาการ'],
            [8,'ฝ่ายประกันคุณภาพ'],
            [9,'ฝ่ายบุคคล'],
            [10,'ฝ่ายต่างประเทศ'],
            [11,'ฝ่ายควบคุมเอกสาร DC'],
            [12,'ฝ่ายการตลาด'],
            [13,'ฝ่ายการเงิน'],
            [14,'ฝ่ายนำเข้า-ส่งออก'],
            [15,'งานรักษาความปลอดภัย(จป.)'],
            [16,'ฝ่าย QA&QC'],
            [17,'ฝ่ายประสานงานขาย'],
            [18,'ฝ่ายสารสนเทศ'],
            [19,'แผนกคลังสินค้า'],
            [20,'ฝ่ายเภสัชกร'],
            [21,'ฝ่ายวิเคราะห์ผลิตภัณฑ์เคมี'],
            [22,'ฝ่ายธุรการประสานงานโครงการ'],
            [23,'ฝ่ายกราฟิคดีไซค์'],
            [24,'ฝ่ายจัดส่งสินค้า'],
            [25,'ฝ่ายควบคุมคุณภาพ']
        ]);

        // Resource User
        // Resource User
        $this->createTable('res_users', [
            'id' => Schema::TYPE_PK,            
            'username' => $this->string(50)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'verifymail_token' => $this->string(50),
            'email' => $this->string(100)->notNull(),
            'code'=>$this->string(30)->comment("รหัสพนักงาน"),
            'id_card' => $this->string(13),
            'firstname' => $this->string(30),
            'lastname' => $this->string(30),
            'active' => $this->boolean(), 
            'company_id' => $this->integer(),
            
            'login_date'=>$this->dateTime()->comment("Login Date"),
            
             //
            'create_uid' => $this->integer(), // Created by
            'create_date' =>$this->timestamp()->defaultValue(null), // Created on
            'write_uid'=> $this->integer(), // Last Updated by
            'write_date' => $this->timestamp()->defaultValue(null), // Last Updated on
        ],$this->tableOptions());
        
        $password_hash = Yii::$app->security->generatePasswordHash('password');

        $this->batchInsert('res_users',['id','username','auth_key','password_hash','email','firstname','lastname','create_uid'],[
            [1,'admin@admin.com','',$password_hash,'admin@admin.com','Mr. Admin','BICGROUP',1],
            [2,'user1@user.com','',$password_hash,'user1@user.com','Mr. User1','BICGROUP',1],
            [3,'user2@user.com','',$password_hash,'user2@user.com','Mr. User2','BICGROUP',1],
            [4,'purchasemanager@user.com','',$password_hash,'purchasemanager@user.com','ผจก. ผู้จัดการ','BICGROUP',1],
            [5,'purchaseofficer@user.com','',$password_hash,'purchaseofficer@user.com','พนง. นักจัดซื้อ','BICGROUP',1],
            [6,'ceo@user.com','',$password_hash,'ceo@user.com','Mr. ผู้บริหาร','BICGROUP',1],
            [7,'manager1@user.com','',$password_hash,'manager1@user.com',' ผจก. สมโชค','BICGROUP',1],
            [8,'employee1@user.com','',$password_hash,'employee1@user.com','พนง. ทุ่มเท','BICGROUP',1],
            [9,'employee2@user.com','',$password_hash,'employee2@user.com','พนง. สุขุม','BICGROUP',1],
            [10,'poweruser@user.com','',$password_hash,'poweruser@user.com','คุณ Power','User',1],
        ]);
        
        $this->createTable('res_users_group_rel',[
            'user_id' => $this->integer()->comment("comment res_users"),
            'group_id'=> $this->integer()->comment('res_groups')
        ]);
        $this->addForeignKey('fk-res_users_group_rel-user_id','res_users_group_rel','user_id','res_users','id','CASCADE');
        $this->addForeignKey('fk-res_users_group_rel-group_id','res_users_group_rel','group_id','res_group','id','CASCADE');
        $this->batchInsert('res_users_group_rel', ['user_id','group_id'], [
            [1,5],
            [1,6],
            [1,18],
            [2,6], //วิศวกรรม
            [3,5], // employee4,จัดซื้อ
            [4,6], // employee4,วิศวกรรม
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-res_users_group_rel-user_id', 'res_users_group_rel');
        $this->dropForeignKey('fk-res_users_group_rel-group_id', 'res_users_group_rel');
        $this->dropTable('res_users');      
        $this->dropTable('res_group');
        $this->dropTable('res_users_group_rel');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180302_020551_init cannot be reverted.\n";

        return false;
    }
    */
}
