<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180511140840 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result_qcm ADD quiz_id INT NOT NULL');
        $this->addSql('ALTER TABLE result_qcm ADD CONSTRAINT FK_53A721FB853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_53A721FB853CD175 ON result_qcm (quiz_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result_qcm DROP FOREIGN KEY FK_53A721FB853CD175');
        $this->addSql('DROP INDEX UNIQ_53A721FB853CD175 ON result_qcm');
        $this->addSql('ALTER TABLE result_qcm DROP quiz_id');
    }
}
