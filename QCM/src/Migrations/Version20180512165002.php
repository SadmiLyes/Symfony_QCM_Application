<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180512165002 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78CB944F1A');
        $this->addSql('DROP INDEX UNIQ_70E4FA78CB944F1A ON member');
        $this->addSql('ALTER TABLE member ADD student_email VARCHAR(255) NOT NULL, DROP student_id, CHANGE is_confirmed is_confirmed TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE result_qcm DROP FOREIGN KEY FK_53A721FB853CD175');
        $this->addSql('DROP INDEX UNIQ_53A721FB853CD175 ON result_qcm');
        $this->addSql('ALTER TABLE result_qcm DROP quiz_id');
        $this->addSql('ALTER TABLE session CHANGE start_date start_date DATE NOT NULL, CHANGE end_date end_date DATE NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX UNIQ_8D93D649D60322AC ON user');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD salt VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP role_id, DROP first_name, DROP last_name');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member ADD student_id INT NOT NULL, DROP student_email, CHANGE is_confirmed is_confirmed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78CB944F1A ON member (student_id)');
        $this->addSql('ALTER TABLE result_qcm ADD quiz_id INT NOT NULL');
        $this->addSql('ALTER TABLE result_qcm ADD CONSTRAINT FK_53A721FB853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_53A721FB853CD175 ON result_qcm (quiz_id)');
        $this->addSql('ALTER TABLE session CHANGE start_date start_date DATETIME NOT NULL, CHANGE end_date end_date DATETIME NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD role_id INT NOT NULL, ADD first_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD last_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP firstname, DROP lastname, DROP password, DROP salt, DROP roles');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D60322AC ON user (role_id)');
    }
}
