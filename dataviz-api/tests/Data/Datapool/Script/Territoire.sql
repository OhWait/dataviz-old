CREATE SCHEMA IF NOT EXISTS territoire;

CREATE TABLE IF NOT EXISTS territoire.commune
(
    annee integer NOT NULL,
    typecom character varying(4) NOT NULL,
    codgeo character varying(5) NOT NULL,
    reg character varying(2),
    dep character varying(3),
    ctcd character varying(4),
    arr character varying(4),
    tncc character varying(1),
    ncc character varying(255) NOT NULL,
    nccenr character varying(255) NOT NULL,
    libelle character varying(255) NOT NULL,
    can character varying(5),
    comparent character varying(5)
);

CREATE TABLE IF NOT EXISTS territoire.departement
(
    annee integer NOT NULL,
    dep character varying(3) NOT NULL,
    reg character varying(2),
    cheflieu character varying(5),
    tncc character varying(1),
    ncc character varying(255) NOT NULL,
    nccenr character varying(255) NOT NULL,
    libelle character varying(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS territoire.epci
(
    annee integer NOT NULL,
    epci character varying(15) NOT NULL,
    libepci character varying(255) NOT NULL,
    nature_epci character varying(255) NOT NULL,
    nb_com integer NOT NULL
);