-- Table: territoire.appartenance
CREATE TABLE IF NOT EXISTS territoire.appartenance
(
  annee integer NOT NULL,
  codgeo character varying(5) NOT NULL,
  canov character varying(5) NOT NULL,
  arr character varying(4) NOT NULL,
  epci character varying(9) NOT NULL,
  dep character varying(3) NOT NULL,
  reg character varying(2) NOT NULL,
  CONSTRAINT appartenance_pkey PRIMARY KEY (annee, codgeo)
) PARTITION BY RANGE (annee);

CREATE TABLE territoire.appartenance_2024 PARTITION OF territoire.appartenance
  FOR VALUES FROM (2024) TO (2025);

CREATE TABLE territoire.appartenance_2025 PARTITION OF territoire.appartenance
  FOR VALUES FROM (2025) TO (2026);



-- Table: territoire.commune
CREATE TABLE IF NOT EXISTS territoire.commune
(
    annee integer NOT NULL,
    typecom character varying(4) NOT NULL,
    codgeo character varying(5) NOT NULL,
    reg character varying(2) DEFAULT NULL::character varying,
    dep character varying(3) DEFAULT NULL::character varying,
    ctcd character varying(4) DEFAULT NULL::character varying,
    arr character varying(4) DEFAULT NULL::character varying,
    tncc character varying(1) DEFAULT NULL::character varying,
    ncc character varying(255) NOT NULL,
    nccenr character varying(255) NOT NULL,
    libelle character varying(255) NOT NULL,
    can character varying(5) DEFAULT NULL::character varying,
    comparent character varying(5) DEFAULT NULL::character varying,
    CONSTRAINT commune_pkey PRIMARY KEY (annee, codgeo)
) PARTITION BY RANGE (annee);

CREATE TABLE territoire.commune_2024 PARTITION OF territoire.commune
  FOR VALUES FROM (2024) TO (2025);

CREATE TABLE territoire.commune_2025 PARTITION OF territoire.commune
  FOR VALUES FROM (2025) TO (2026);



-- Table: territoire.epci
CREATE TABLE IF NOT EXISTS territoire.epci
(
    annee integer NOT NULL,
    epci character varying(9) NOT NULL,
    libepci character varying(255) NOT NULL,
    nature character varying(10) NOT NULL,
    CONSTRAINT epci_pkey PRIMARY KEY (annee, epci)
) PARTITION BY RANGE (annee);

CREATE TABLE territoire.epci_2024 PARTITION OF territoire.epci
    FOR VALUES FROM (2024) TO (2025);

CREATE TABLE territoire.epci_2025 PARTITION OF territoire.epci
    FOR VALUES FROM (2025) TO (2026);



  -- Table: territoire.departement
CREATE TABLE IF NOT EXISTS territoire.departement
(
    annee integer NOT NULL,
    dep character varying(3) NOT NULL,
    reg character varying(2) DEFAULT NULL::character varying,
    cheflieu character varying(5) DEFAULT NULL::character varying,
    tncc character varying(1) DEFAULT NULL::character varying,
    ncc character varying(255) NOT NULL,
    nccenr character varying(255) NOT NULL,
    libdep character varying(255) NOT NULL,
    CONSTRAINT departement_pkey PRIMARY KEY (annee, dep)
) PARTITION BY RANGE (annee);

CREATE TABLE territoire.departement_2024 PARTITION OF territoire.departement
  FOR VALUES FROM (2024) TO (2025);

CREATE TABLE territoire.departement_2025 PARTITION OF territoire.departement
  FOR VALUES FROM (2025) TO (2026);
