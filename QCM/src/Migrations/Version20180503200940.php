<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180503200940 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE class_room (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, session_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C6E266D4F675F31B (author_id), INDEX IDX_C6E266D4613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, is_confirmed TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_70E4FA789D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_class_room (member_id INT NOT NULL, class_room_id INT NOT NULL, INDEX IDX_2DAC783D7597D3FE (member_id), INDEX IDX_2DAC783D9162176F (class_room_id), PRIMARY KEY(member_id, class_room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, quiz_id_id INT DEFAULT NULL, enunciate VARCHAR(255) NOT NULL, is_multiple TINYINT(1) NOT NULL, INDEX IDX_B6F7494E8337E7D7 (quiz_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, max_points INT NOT NULL, right_amount_points INT NOT NULL, wrong_amount_points INT NOT NULL, neutral_amount_points INT NOT NULL, INDEX IDX_A412FA92F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_qcm (id INT AUTO_INCREMENT NOT NULL, student_id_id INT DEFAULT NULL, quiz_id_id INT DEFAULT NULL, session_id_id INT DEFAULT NULL, mark DOUBLE PRECISION NOT NULL, INDEX IDX_53A721FBF773E7CA (student_id_id), UNIQUE INDEX UNIQ_53A721FB8337E7D7 (quiz_id_id), INDEX IDX_53A721FBA4392681 (session_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result_question (id INT AUTO_INCREMENT NOT NULL, result_qcm_id_id INT DEFAULT NULL, given TINYINT(1) NOT NULL, INDEX IDX_11F256ADC8CE2CF0 (result_qcm_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, quiz_id_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_D044D5D4F675F31B (author_id), INDEX IDX_D044D5D48337E7D7 (quiz_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, question_id_id INT DEFAULT NULL, result_question_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, is_right TINYINT(1) NOT NULL, INDEX IDX_DD80F31B4FAF8F53 (question_id_id), INDEX IDX_DD80F31B8B362F0 (result_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, gender VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64988987678 (role_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_room ADD CONSTRAINT FK_C6E266D4F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE class_room ADD CONSTRAINT FK_C6E266D4613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA789D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member_class_room ADD CONSTRAINT FK_2DAC783D7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_class_room ADD CONSTRAINT FK_2DAC783D9162176F FOREIGN KEY (class_room_id) REFERENCES class_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E8337E7D7 FOREIGN KEY (quiz_id_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE result_qcm ADD CONSTRAINT FK_53A721FBF773E7CA FOREIGN KEY (student_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE result_qcm ADD CONSTRAINT FK_53A721FB8337E7D7 FOREIGN KEY (quiz_id_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE result_qcm ADD CONSTRAINT FK_53A721FBA4392681 FOREIGN KEY (session_id_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE result_question ADD CONSTRAINT FK_11F256ADC8CE2CF0 FOREIGN KEY (result_qcm_id_id) REFERENCES result_qcm (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D48337E7D7 FOREIGN KEY (quiz_id_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B4FAF8F53 FOREIGN KEY (question_id_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31B8B362F0 FOREIGN KEY (result_question_id) REFERENCES result_question (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64988987678 FOREIGN KEY (role_id_id) REFERENCES role (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member_class_room DROP FOREIGN KEY FK_2DAC783D9162176F');
        $this->addSql('ALTER TABLE member_class_room DROP FOREIGN KEY FK_2DAC783D7597D3FE');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B4FAF8F53');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E8337E7D7');
        $this->addSql('ALTER TABLE result_qcm DROP FOREIGN KEY FK_53A721FB8337E7D7');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D48337E7D7');
        $this->addSql('ALTER TABLE result_question DROP FOREIGN KEY FK_11F256ADC8CE2CF0');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31B8B362F0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64988987678');
        $this->addSql('ALTER TABLE class_room DROP FOREIGN KEY FK_C6E266D4613FECDF');
        $this->addSql('ALTER TABLE result_qcm DROP FOREIGN KEY FK_53A721FBA4392681');
        $this->addSql('ALTER TABLE class_room DROP FOREIGN KEY FK_C6E266D4F675F31B');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA789D86650F');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92F675F31B');
        $this->addSql('ALTER TABLE result_qcm DROP FOREIGN KEY FK_53A721FBF773E7CA');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4F675F31B');
        $this->addSql('DROP TABLE class_room');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE member_class_room');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE result_qcm');
        $this->addSql('DROP TABLE result_question');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE user');
    }
}
