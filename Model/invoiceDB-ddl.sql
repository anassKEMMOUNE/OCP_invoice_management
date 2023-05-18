DROP DATABASE IF EXISTS invoiceDb;

CREATE DATABASE invoiceDb;

USE invoiceDb;

DROP TABLE IF EXISTS Fournisseur;

CREATE TABLE Fournisseur (
  codeFournisseur INTEGER PRIMARY KEY NOT NULL,
  nomFournisseur VARCHAR(100) NOT NULL,
  siteFournisseur VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS Entite;

CREATE TABLE Entite (
  idE INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nomEntite VARCHAR(100) NOT NULL,
  entiteSite VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS ChefDeProjet;

CREATE TABLE ChefDeProjet (
  idCDP INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  idE INTEGER NOT NULL,
  nomCDP VARCHAR(100) NOT NULL,
  FOREIGN KEY (idE) REFERENCES Entite(idE)
);

DROP TABLE IF EXISTS Commande;

CREATE TABLE Commande (
  numCommande VARCHAR(55) PRIMARY KEY NOT NULL,
  service VARCHAR(100) NOT NULL,
  typeDAchatPO VARCHAR(100) NOT NULL,
  uniteOperationelle VARCHAR(100) NOT NULL,
  montantCommande FLOAT NOT NULL,
  montantReceptionne FLOAT NOT NULL,
  acheteur VARCHAR(100) NOT NULL,
  codeFournisseur INTEGER NOT NULL,
  idCDP INTEGER NOT NULL,
  FOREIGN KEY (codeFournisseur) REFERENCES Fournisseur(codeFournisseur),
  FOREIGN KEY (idCDP) REFERENCES ChefDeProjet(idCDP)
);

DROP TABLE IF EXISTS Facture;

CREATE TABLE Facture (
  identifiantGED VARCHAR(55) PRIMARY KEY NOT NULL,
  numeroFacture VARCHAR(100) NOT NULL,
  montantDesFactures FLOAT NOT NULL,
  montantFactureTTCDevise FLOAT NOT NULL,
  montantMiseADisposition FLOAT NOT NULL,
  intervenant VARCHAR(100) NOT NULL,
  nombreDeJoursAEcheance INTEGER NOT NULL,
  cA VARCHAR(100) NOT NULL,
  blocage VARCHAR(100) NOT NULL,
  numCommande VARCHAR(55) NOT NULL,
  idE INTEGER NOT NULL,
  siteCEC VARCHAR(100) NOT NULL,
  deviseFacture VARCHAR(100) NOT NULL,
  typeF VARCHAR(100) NOT NULL,
  entiteG VARCHAR(100) NOT NULL,
  rank_ INTEGER NOT NULL,
  FOREIGN KEY (numCommande) REFERENCES Commande(numCommande),
  FOREIGN KEY (idE) REFERENCES Entite(idE)
);

CREATE VIEW Facture_View AS
SELECT *,
    CASE
        WHEN nombreDeJoursAEcheance < 0 THEN 'Echue'
        WHEN nombreDeJoursAEcheance <= 7 THEN 'Echue dans 7 jours'
        WHEN nombreDeJoursAEcheance <= 30 THEN 'Echue dans 30 jours'
        WHEN nombreDeJoursAEcheance <= 60 THEN 'Echue dans 60 jours'
    END AS echeance
FROM Facture;


CREATE INDEX idx_Facture_NombreDeJours ON invoiceDb.Facture(nombreDeJoursAEcheance);
CREATE INDEX idx_Facture_ContractAdmin ON Facture(CA);