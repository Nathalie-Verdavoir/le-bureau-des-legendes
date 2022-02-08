<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208135414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, nom_de_code_id INT DEFAULT NULL, nationalite_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_de_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_9596AB6E1A8D48E3 (nom_de_code_id), INDEX IDX_9596AB6E1B063272 (nationalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_specialites (agents_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_F6BF24EA709770DC (agents_id), INDEX IDX_F6BF24EA5AEDDAD9 (specialites_id), PRIMARY KEY(agents_id, specialites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cibles (id INT AUTO_INCREMENT NOT NULL, nom_de_code_id INT NOT NULL, nationalite_id INT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_de_naissance DATE NOT NULL, UNIQUE INDEX UNIQ_AAE47BC31A8D48E3 (nom_de_code_id), INDEX IDX_AAE47BC31B063272 (nationalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, nom_de_code_id INT NOT NULL, nationalite_id INT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_de_naissance DATE DEFAULT NULL, UNIQUE INDEX UNIQ_334015731A8D48E3 (nom_de_code_id), INDEX IDX_334015731B063272 (nationalite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, nom_de_code_id INT NOT NULL, pays_id INT NOT NULL, type_id INT NOT NULL, statut_id INT NOT NULL, specialite_id INT NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, UNIQUE INDEX UNIQ_34F1D47E1A8D48E3 (nom_de_code_id), INDEX IDX_34F1D47EA6E44244 (pays_id), INDEX IDX_34F1D47EC54C8C93 (type_id), INDEX IDX_34F1D47EF6203804 (statut_id), INDEX IDX_34F1D47E2195E0F0 (specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_agents (missions_id INT NOT NULL, agents_id INT NOT NULL, INDEX IDX_5340AFB917C042CF (missions_id), INDEX IDX_5340AFB9709770DC (agents_id), PRIMARY KEY(missions_id, agents_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_contacts (missions_id INT NOT NULL, contacts_id INT NOT NULL, INDEX IDX_FA54446417C042CF (missions_id), INDEX IDX_FA544464719FB48E (contacts_id), PRIMARY KEY(missions_id, contacts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_cibles (missions_id INT NOT NULL, cibles_id INT NOT NULL, INDEX IDX_6C327F1417C042CF (missions_id), INDEX IDX_6C327F149E046BDF (cibles_id), PRIMARY KEY(missions_id, cibles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_planques (missions_id INT NOT NULL, planques_id INT NOT NULL, INDEX IDX_F9E5FE8A17C042CF (missions_id), INDEX IDX_F9E5FE8A70AF8C0F (planques_id), PRIMARY KEY(missions_id, planques_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nom_de_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planques (id INT AUTO_INCREMENT NOT NULL, code_id INT NOT NULL, pays_id INT NOT NULL, type_id INT NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_30F1AF9D27DAFE17 (code_id), INDEX IDX_30F1AF9DA6E44244 (pays_id), INDEX IDX_30F1AF9DC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialites (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, etat VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_missions (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_de_planques (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6E1A8D48E3 FOREIGN KEY (nom_de_code_id) REFERENCES nom_de_code (id)');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6E1B063272 FOREIGN KEY (nationalite_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_specialites ADD CONSTRAINT FK_F6BF24EA5AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cibles ADD CONSTRAINT FK_AAE47BC31A8D48E3 FOREIGN KEY (nom_de_code_id) REFERENCES nom_de_code (id)');
        $this->addSql('ALTER TABLE cibles ADD CONSTRAINT FK_AAE47BC31B063272 FOREIGN KEY (nationalite_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_334015731A8D48E3 FOREIGN KEY (nom_de_code_id) REFERENCES nom_de_code (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_334015731B063272 FOREIGN KEY (nationalite_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E1A8D48E3 FOREIGN KEY (nom_de_code_id) REFERENCES nom_de_code (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EC54C8C93 FOREIGN KEY (type_id) REFERENCES type_de_missions (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EF6203804 FOREIGN KEY (statut_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialites (id)');
        $this->addSql('ALTER TABLE missions_agents ADD CONSTRAINT FK_5340AFB917C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_agents ADD CONSTRAINT FK_5340AFB9709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_contacts ADD CONSTRAINT FK_FA54446417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_contacts ADD CONSTRAINT FK_FA544464719FB48E FOREIGN KEY (contacts_id) REFERENCES contacts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_cibles ADD CONSTRAINT FK_6C327F1417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_cibles ADD CONSTRAINT FK_6C327F149E046BDF FOREIGN KEY (cibles_id) REFERENCES cibles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_planques ADD CONSTRAINT FK_F9E5FE8A17C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_planques ADD CONSTRAINT FK_F9E5FE8A70AF8C0F FOREIGN KEY (planques_id) REFERENCES planques (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planques ADD CONSTRAINT FK_30F1AF9D27DAFE17 FOREIGN KEY (code_id) REFERENCES nom_de_code (id)');
        $this->addSql('ALTER TABLE planques ADD CONSTRAINT FK_30F1AF9DA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE planques ADD CONSTRAINT FK_30F1AF9DC54C8C93 FOREIGN KEY (type_id) REFERENCES type_de_planques (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agents_specialites DROP FOREIGN KEY FK_F6BF24EA709770DC');
        $this->addSql('ALTER TABLE missions_agents DROP FOREIGN KEY FK_5340AFB9709770DC');
        $this->addSql('ALTER TABLE missions_cibles DROP FOREIGN KEY FK_6C327F149E046BDF');
        $this->addSql('ALTER TABLE missions_contacts DROP FOREIGN KEY FK_FA544464719FB48E');
        $this->addSql('ALTER TABLE missions_agents DROP FOREIGN KEY FK_5340AFB917C042CF');
        $this->addSql('ALTER TABLE missions_contacts DROP FOREIGN KEY FK_FA54446417C042CF');
        $this->addSql('ALTER TABLE missions_cibles DROP FOREIGN KEY FK_6C327F1417C042CF');
        $this->addSql('ALTER TABLE missions_planques DROP FOREIGN KEY FK_F9E5FE8A17C042CF');
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6E1A8D48E3');
        $this->addSql('ALTER TABLE cibles DROP FOREIGN KEY FK_AAE47BC31A8D48E3');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_334015731A8D48E3');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E1A8D48E3');
        $this->addSql('ALTER TABLE planques DROP FOREIGN KEY FK_30F1AF9D27DAFE17');
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6E1B063272');
        $this->addSql('ALTER TABLE cibles DROP FOREIGN KEY FK_AAE47BC31B063272');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_334015731B063272');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47EA6E44244');
        $this->addSql('ALTER TABLE planques DROP FOREIGN KEY FK_30F1AF9DA6E44244');
        $this->addSql('ALTER TABLE missions_planques DROP FOREIGN KEY FK_F9E5FE8A70AF8C0F');
        $this->addSql('ALTER TABLE agents_specialites DROP FOREIGN KEY FK_F6BF24EA5AEDDAD9');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E2195E0F0');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47EF6203804');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47EC54C8C93');
        $this->addSql('ALTER TABLE planques DROP FOREIGN KEY FK_30F1AF9DC54C8C93');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE agents_specialites');
        $this->addSql('DROP TABLE cibles');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE missions_agents');
        $this->addSql('DROP TABLE missions_contacts');
        $this->addSql('DROP TABLE missions_cibles');
        $this->addSql('DROP TABLE missions_planques');
        $this->addSql('DROP TABLE nom_de_code');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE planques');
        $this->addSql('DROP TABLE specialites');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type_de_missions');
        $this->addSql('DROP TABLE type_de_planques');
    }
}
