CREATE SCHEMA IF NOT EXISTS etat;

DROP TABLE IF EXISTS etat.acc_vehicule;
DROP TABLE IF EXISTS etat.acc_usager;
DROP TABLE IF EXISTS etat.acc_lieu;
DROP TABLE IF EXISTS etat.acc_caracteristique;

CREATE TABLE IF NOT EXISTS etat.acc_caracteristique
(
    num_acc character varying NOT NULL,
    date timestamp without time zone NOT NULL,
    lum character varying(1),
    codgeo character varying(5),
    agg character varying(1),
    inter character varying(1),
    atm character varying(2),
    col character varying(2),
    address character varying(255),
    lat numeric,
    lng numeric,
    CONSTRAINT acc_caracteristique_pkey PRIMARY KEY (num_acc)
) PARTITION BY RANGE (num_acc);

CREATE TABLE etat.acc_caracteristique_2021
PARTITION OF etat.acc_caracteristique
FOR VALUES FROM ('202100000000') TO ('202200000000');

CREATE TABLE IF NOT EXISTS etat.acc_lieu
(
    num_acc character varying NOT NULL,
    catr character varying(1),
    voie character varying(255),
    v1 character varying(255),
    v2 character varying(255),
    circ character varying(2),
    nbv integer,
    vosp character varying(2),
    prof character varying(2),
    pr character varying(255),
    pr1 character varying(255),
    plan character varying(2),
    lartpc character varying(255),
    larrout character varying(255),
    surf character varying(2),
    infra character varying(2),
    situ character varying(2),
    vma integer,
    CONSTRAINT acc_caracteristique FOREIGN KEY (num_acc)
        REFERENCES etat.acc_caracteristique (num_acc) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
) PARTITION BY RANGE (num_acc);

CREATE TABLE etat.acc_lieu_2021
PARTITION OF etat.acc_lieu
FOR VALUES FROM ('202100000000') TO ('202200000000');

CREATE TABLE IF NOT EXISTS etat.acc_usager
(
    num_acc character varying NOT NULL,
    id_usager character varying(255),
    id_vehicule character varying(255),
    num_vehicule character varying(255),
    place character varying(255),
    catu character varying(2),
    grav character varying(2),
    sexe character varying(2),
    an_nais integer,
    trajet character varying(2),
    secu character varying(255),
    secu1 character varying(2),
    secu2 character varying(2),
    secu3 character varying(2),
    locp character varying(2),
    actp character varying(2),
    etatp character varying(2),
    CONSTRAINT acc_caracteristique FOREIGN KEY (num_acc)
        REFERENCES etat.acc_caracteristique (num_acc) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
) PARTITION BY RANGE (num_acc);

CREATE TABLE etat.acc_usager_2021
PARTITION OF etat.acc_usager
FOR VALUES FROM ('202100000000') TO ('202200000000');

CREATE TABLE IF NOT EXISTS etat.acc_vehicule
(
    num_acc character varying NOT NULL,
    id_vehicule character varying(255),
    num_veh character varying(255),
    senc character varying(2),
    catv character varying(2),
    obs character varying(2),
    obsm character varying(2),
    choc character varying(2),
    manv character varying(2),
    motor character varying(2),
    occutc integer,
    CONSTRAINT acc_caracteristique FOREIGN KEY (num_acc)
        REFERENCES etat.acc_caracteristique (num_acc) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
) PARTITION BY RANGE (num_acc);

CREATE TABLE etat.acc_vehicule_2021
PARTITION OF etat.acc_vehicule
FOR VALUES FROM ('202100000000') TO ('202200000000');