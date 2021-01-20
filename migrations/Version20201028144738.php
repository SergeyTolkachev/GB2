<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028144738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('insert into users set name = :name, email = :email, password = :password, created_at = now(), updated_at = now()',
            [   'name' => 'Sergey',
                'email'=> 'sergei.tolkachev@ukr.net',
                'password' => '27061986'
            ]
        );

        $this->addSql('insert into users set name = :name, email = :email, password = :password, created_at = now(), updated_at = now()',
            [   'name' => 'Igor',
                'email'=> 'igor.kochurka@ukr.net',
                'password' => '05021986'
            ]
        );

        $this->addSql('insert into users set name = :name, email = :email, password = :password, created_at = now(), updated_at = now()',
            [   'name' => 'Svetlana',
                'email'=> 'svetlana.mikhailova@ukr.net',
                'password' => '04011985'
            ]
        );

        $this->addSql('insert into posts set user_id = :user_id, topic = :topic, description = :description, created_at = now(), updated_at = now()',
            [
                'user_id' =>'1',
                'topic' => 'Не могу воспользоваться услугой',
                'description'=> 'Не получается то-то и то-то'
            ]
        );

        $this->addSql('insert into posts set user_id = :user_id, topic = :topic, description = :description, created_at = now(), updated_at = now()',
            [
                'user_id' =>'2',
                'topic' => 'Оформление',
                'description'=> 'НЕ могу нормально оформить задачу'
            ]
        );

        $this->addSql('insert into posts set user_id = :user_id, topic = :topic, description = :description, created_at = now(), updated_at = now()',
            [
                'user_id' =>'3',
                'topic' => 'Ничего не работает!',
                'description'=> 'Привет у меня ничего не работает что мне делать?'
            ]
        );



    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
