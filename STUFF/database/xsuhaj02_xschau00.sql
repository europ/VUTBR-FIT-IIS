--*******************************************************
--*********** VUT FIT IDS project - part 4  *************
--*******************************************************
-- Authors:                       *
--  Peter Suhaj   (xsuhaj02)              *
--  Marek Schauer   (xschau00)              *
--*******************************************************
--*******************************************************

DROP TABLE leky CASCADE CONSTRAINT;
DROP TABLE pobocky  CASCADE CONSTRAINT;
DROP TABLE rezervace CASCADE CONSTRAINT;
DROP TABLE pojistovny CASCADE CONSTRAINT;
DROP TABLE predpisy CASCADE CONSTRAINT;
DROP TABLE leky_na_pobockach CASCADE CONSTRAINT;
DROP TABLE prodane_leky CASCADE CONSTRAINT;
DROP TABLE doplatky_pojistoven CASCADE CONSTRAINT;
DROP TABLE ceny_dodavatelu CASCADE CONSTRAINT;
DROP TABLE dodavatele CASCADE CONSTRAINT;
DROP TABLE rezervace_leky CASCADE CONSTRAINT;
DROP TABLE predpisy_leky CASCADE CONSTRAINT;
DROP MATERIALIZED VIEW rezervaceView;
DROP SEQUENCE seq_leky;
DROP SEQUENCE seq_pobocky;
DROP SEQUENCE seq_rezervace;
DROP SEQUENCE seq_pojistovny;
DROP SEQUENCE seq_predpisy;
DROP SEQUENCE seq_dodavatele;
DROP SEQUENCE seq_prodane_leky;


CREATE TABLE leky (
id_leku INTEGER NOT NULL,
nazev VARCHAR(30) NOT NULL,
cena INTEGER NOT NULL
);
ALTER TABLE leky ADD(PRIMARY KEY(id_leku));
CREATE SEQUENCE seq_leky MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;

CREATE TABLE pobocky (
id_pobocky INTEGER NOT NULL,
nazev_pobocky VARCHAR(30) NOT NULL,
adresa_ulice VARCHAR(30) NOT NULL,
adresa_cislo VARCHAR(15) NOT NULL,
adresa_mesto VARCHAR(30) NOT NULL,
adresa_psc INTEGER NOT NULL
);
ALTER TABLE pobocky ADD(PRIMARY KEY(id_pobocky));
CREATE SEQUENCE seq_pobocky MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;


CREATE TABLE rezervace (
id_rezervace INTEGER NOT NULL,
jmeno_zakaznika VARCHAR(30) NOT NULL,
datum_vytvoreni DATE NOT NULL
);
ALTER TABLE rezervace ADD(PRIMARY KEY(id_rezervace));
CREATE SEQUENCE seq_rezervace MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;

--n ku n vztah
CREATE TABLE rezervace_leky (
id_leku INTEGER NOT NULL,
id_rezervace INTEGER NOT NULL
);
ALTER TABLE rezervace_leky ADD(PRIMARY KEY(id_rezervace,id_leku));
ALTER TABLE rezervace_leky ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE rezervace_leky ADD( FOREIGN KEY(id_rezervace) REFERENCES rezervace(id_rezervace));

CREATE TABLE pojistovny (
id_pojistovny INTEGER NOT NULL,
nazev_pojistovny VARCHAR(80) NOT NULL
);
ALTER TABLE pojistovny ADD(PRIMARY KEY(id_pojistovny));
CREATE SEQUENCE seq_pojistovny MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;


CREATE TABLE predpisy (
id_predpisu INTEGER NOT NULL,
rodne_cislo INTEGER NOT NULL,
id_pojistovny INTEGER
);
ALTER TABLE predpisy ADD(PRIMARY KEY(id_predpisu));
ALTER TABLE predpisy ADD( FOREIGN KEY(id_pojistovny) REFERENCES pojistovny(id_pojistovny));
CREATE SEQUENCE seq_predpisy MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;

--n ku n vztah
CREATE TABLE predpisy_leky (
id_leku INTEGER NOT NULL,
id_predpisu INTEGER NOT NULL
);
ALTER TABLE predpisy_leky ADD(PRIMARY KEY(id_predpisu,id_leku));
ALTER TABLE predpisy_leky ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE predpisy_leky ADD( FOREIGN KEY(id_predpisu) REFERENCES predpisy(id_predpisu));


CREATE TABLE dodavatele (
id_dodavatele INTEGER NOT NULL,
nazev VARCHAR(100) NOT NULL,
typ INTEGER NOT NULL,
datum_dodani DATE,
platnost_smlouvy_od DATE,
platnost_smlouvy_do DATE
);
ALTER TABLE dodavatele ADD(PRIMARY KEY(id_dodavatele));
CREATE SEQUENCE seq_dodavatele MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;

CREATE TABLE leky_na_pobockach (
mnozstvi INTEGER NOT NULL,
id_pobocky INTEGER NOT NULL,
id_leku INTEGER NOT NULL
);
ALTER TABLE leky_na_pobockach ADD(PRIMARY KEY(id_pobocky,id_leku));
ALTER TABLE leky_na_pobockach ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE leky_na_pobockach ADD( FOREIGN KEY(id_pobocky) REFERENCES pobocky(id_pobocky));

CREATE TABLE prodane_leky (
id_prodej INTEGER NOT NULL,
mnozstvi INTEGER NOT NULL,
datum DATE NOT NULL,
id_pobocky INTEGER NOT NULL,
id_leku INTEGER NOT NULL
);
ALTER TABLE prodane_leky ADD(PRIMARY KEY(id_prodej));
ALTER TABLE prodane_leky ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE prodane_leky ADD( FOREIGN KEY(id_pobocky) REFERENCES pobocky(id_pobocky));
CREATE SEQUENCE seq_prodane_leky MINVALUE 1 NOMAXVALUE START WITH 1 INCREMENT BY 1;

CREATE TABLE doplatky_pojistoven (
hrazena_cast INTEGER NOT NULL,
id_leku INTEGER NOT NULL,
id_pojistovny INTEGER NOT NULL
);
ALTER TABLE doplatky_pojistoven ADD(PRIMARY KEY(id_pojistovny,id_leku));
ALTER TABLE doplatky_pojistoven ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE doplatky_pojistoven ADD( FOREIGN KEY(id_pojistovny) REFERENCES pojistovny(id_pojistovny));


CREATE TABLE ceny_dodavatelu (
cena INTEGER NOT NULL,
id_leku INTEGER NOT NULL,
id_dodavatele INTEGER NOT NULL
);
ALTER TABLE ceny_dodavatelu ADD(PRIMARY KEY(id_dodavatele,id_leku));
ALTER TABLE ceny_dodavatelu ADD( FOREIGN KEY(id_leku) REFERENCES leky(id_leku));
ALTER TABLE ceny_dodavatelu ADD( FOREIGN KEY(id_dodavatele) REFERENCES dodavatele(id_dodavatele));

ALTER TABLE leky ADD CONSTRAINT cenaViacNezNula CHECK (cena>0);
ALTER TABLE doplatky_pojistoven ADD CONSTRAINT hrazenaCastViacNezNula CHECK (hrazena_cast>0);
ALTER TABLE prodane_leky ADD CONSTRAINT prodaneLekyVicNezNula CHECK (mnozstvi>0);
-- ALTER TABLE predpisy ADD CONSTRAINT kontrolaRodnihoCisla CHECK (MOD(rodne_cislo,11) = 0);

--============================================================================
-- Vytvoreni  dvou netrivialnich databazovych triggeru vc. jejich predvedeni
--============================================================================
-- --------------------------------
-- Vytvoreni triggeru pro vlozeni primarnich klicu do tabulky 'leky'
-- --------------------------------
CREATE OR REPLACE TRIGGER lekyautoincrement
  BEFORE INSERT ON leky
  FOR EACH ROW
  WHEN (new.id_leku IS NULL)
BEGIN
  :NEW.id_leku := seq_leky.nextval;
END;
/

-- --------------------------------
-- Vytvoreni triggeru pro overeni rodniho cisla
-- --------------------------------
CREATE OR REPLACE TRIGGER rodnicislo
  BEFORE INSERT OR UPDATE ON predpisy
  FOR EACH ROW
DECLARE
  prvni_cast_cisla INTEGER;
  posledni_cislice INTEGER;
BEGIN
  IF (:new.rodne_cislo > 9999999999 OR :new.rodne_cislo < 1000000000)
  THEN
      Raise_Application_Error (-20001, 'Nespravny format pro rodni cislo');
    END IF;
    prvni_cast_cisla := TRUNC(:new.rodne_cislo / 10, 0);
    posledni_cislice := MOD(:new.rodne_cislo, 10);

    IF (MOD(prvni_cast_cisla,11) = 10 AND posledni_cislice != 0)
    THEN
      Raise_Application_Error (-20002, 'Nespravny format pro rodni cislo');
    ELSIF (MOD(prvni_cast_cisla,11) != posledni_cislice)
    THEN
      Raise_Application_Error (-20003, 'Nespravny format pro rodni cislo');
    END IF;
END;
/
 


--procedura na zistenie vydanych liekov na predpis v danej pobocke v danom datume
--format datumu DD/MM/YY
SET SERVEROUTPUT ON;
CREATE OR REPLACE PROCEDURE lieky_na_predpis(datum_predaja IN VARCHAR,pobocka IN VARCHAR2) IS
 --pocet INTEGER;
 nothing_found EXCEPTION;
 CURSOR kurzor IS SELECT DISTINCT id_leku,nazev FROM leky NATURAL JOIN predpisy_leky NATURAL JOIN predpisy;
 CURSOR prodej IS SELECT id_leku,nazev_pobocky,datum FROM leky NATURAL JOIN prodane_leky NATURAL JOIN pobocky WHERE nazev_pobocky=pobocka AND datum = TO_DATE(datum_predaja,'DD/MM/YY');
 kurzor_data kurzor%ROWTYPE;
 prodej_data prodej%ROWTYPE;
 found INTEGER;
 BEGIN
 found :=0;
 OPEN kurzor;
 LOOP
	FETCH kurzor into kurzor_data;
	exit when kurzor%NOTFOUND;
	OPEN prodej;
	LOOP
		FETCH prodej INTO prodej_data;
		exit when prodej%NOTFOUND;
		IF (prodej_data.id_leku = kurzor_data.id_leku) THEN-- AND prodej_data.nazev_pobocky=pobocka AND prodej_data.datum = TO_DATE(datum_predaja,'DD/MM/YY')) THEN
			DBMS_output.put_line('Liek: ' || kurzor_data.nazev);
			found := found +1;
		END IF;
	END LOOP;
	CLOSE prodej;
 END LOOP;  
 CLOSE kurzor;
 IF (found = 0) THEN
 	RAISE nothing_found;
 END IF;
 EXCEPTION
   WHEN nothing_found THEN
   	  DBMS_output.put_line('V dany den na tejto pobocke nebol vydany liek na predpis.'); 
   WHEN others THEN 
      Raise_Application_Error (-20004, 'CHYBA!!!');
 END;
/


CREATE OR REPLACE PROCEDURE dodavatel(nazev_leku IN VARCHAR2) IS 
CURSOR dodav IS SELECT leky.nazev AS nazev,dodavatele.nazev AS nazev_dodavatela FROM leky INNER JOIN ceny_dodavatelu ON (leky.id_leku = ceny_dodavatelu.id_leku) INNER JOIN dodavatele ON (ceny_dodavatelu.id_dodavatele = dodavatele.id_dodavatele);
dodav_data dodav%ROWTYPE;
found INTEGER;
nothing_found EXCEPTION;
BEGIN
found :=0;
OPEN dodav;
LOOP
	FETCH dodav INTO dodav_data;
	exit when dodav%NOTFOUND;
	IF (dodav_data.nazev = nazev_leku) THEN
		DBMS_output.put_line('Dodavatel: ' || dodav_data.nazev_dodavatela);
		found := found +1;
	END IF; 
END LOOP;
CLOSE dodav;
IF (found = 0) THEN
 	RAISE nothing_found;
END IF;
EXCEPTION
   WHEN nothing_found THEN 
      DBMS_output.put_line('Nebol najdeny dodavatel pre tento liek.');
   WHEN others THEN 
      Raise_Application_Error (-20005, 'CHYBA!!!');
END;
/

--============================================================================
-- Definice pristupovych prav k databazovym objektum pro druheho clena tymu
--============================================================================
GRANT ALL ON leky TO xsuhaj02;
GRANT ALL ON pobocky  TO xsuhaj02;
GRANT ALL ON rezervace TO xsuhaj02;
GRANT ALL ON pojistovny TO xsuhaj02;
GRANT ALL ON predpisy TO xsuhaj02;
GRANT ALL ON leky_na_pobockach TO xsuhaj02;
GRANT ALL ON prodane_leky TO xsuhaj02;
GRANT ALL ON doplatky_pojistoven TO xsuhaj02;
GRANT ALL ON ceny_dodavatelu TO xsuhaj02;
GRANT ALL ON dodavatele TO xsuhaj02;
GRANT ALL ON rezervace_leky TO xsuhaj02;
GRANT ALL ON predpisy_leky TO xsuhaj02;


--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY LEKY
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO leky VALUES(seq_leky.nextval,'Addaven',1084);
INSERT INTO leky VALUES(seq_leky.nextval,'Akineton',453);
INSERT INTO leky VALUES(seq_leky.nextval,'Alvesco',967);
INSERT INTO leky VALUES(seq_leky.nextval,'Anaya',464);
INSERT INTO leky VALUES(seq_leky.nextval,'Apo-Losartan',477);
INSERT INTO leky VALUES(seq_leky.nextval,'Arlevert',132);
INSERT INTO leky VALUES(seq_leky.nextval,'Aterogan',545);
INSERT INTO leky VALUES(seq_leky.nextval,'Baktevir',903);
INSERT INTO leky VALUES(seq_leky.nextval,'Betaserc',1044);
INSERT INTO leky VALUES(seq_leky.nextval,'Blessin Plus H',805);
INSERT INTO leky VALUES(seq_leky.nextval,'Buprenorphine Alkaloid',1416);
INSERT INTO leky VALUES(seq_leky.nextval,'Cardiket Retard',1044);
INSERT INTO leky VALUES(seq_leky.nextval,'Cholagol',361);
INSERT INTO leky VALUES(seq_leky.nextval,'Clobex',890);
INSERT INTO leky VALUES(seq_leky.nextval,'Copaxone',1022);
INSERT INTO leky VALUES(seq_leky.nextval,'Dafiro HCT',988);
INSERT INTO leky VALUES(seq_leky.nextval,'Dexoket',1160);
INSERT INTO leky VALUES(seq_leky.nextval,'Diprosone',1437);
INSERT INTO leky VALUES(seq_leky.nextval,'Duloxetin',472);
INSERT INTO leky VALUES(seq_leky.nextval,'Egiramlon',1360);
INSERT INTO leky VALUES(seq_leky.nextval,'Enoki',1349);
INSERT INTO leky VALUES(seq_leky.nextval,'Esomeprazol',1164);
INSERT INTO leky VALUES(seq_leky.nextval,'Famosan',1285);
INSERT INTO leky VALUES(seq_leky.nextval,'Flamexin',814);
INSERT INTO leky VALUES(seq_leky.nextval,'Forsteo',129);
INSERT INTO leky VALUES(seq_leky.nextval,'Gallax',204);
INSERT INTO leky VALUES(seq_leky.nextval,'Gleperil',958);
INSERT INTO leky VALUES(seq_leky.nextval,'Gyno-Pevaryl',447);
INSERT INTO leky VALUES(seq_leky.nextval,'Hyalgel',1098);
INSERT INTO leky VALUES(seq_leky.nextval,'Imprida',608);
INSERT INTO leky VALUES(seq_leky.nextval,'Isame',1471);
INSERT INTO leky VALUES(seq_leky.nextval,'Kanavit',681);
INSERT INTO leky VALUES(seq_leky.nextval,'Kreon',982);
INSERT INTO leky VALUES(seq_leky.nextval,'Lectazib',937);
INSERT INTO leky VALUES(seq_leky.nextval,'Levothyroxine',1066);
INSERT INTO leky VALUES(seq_leky.nextval,'Lomir',1380);
INSERT INTO leky VALUES(seq_leky.nextval,'Magrilan',990);
INSERT INTO leky VALUES(seq_leky.nextval,'Melovis',110);
INSERT INTO leky VALUES(seq_leky.nextval,'Milgamma N',782);
INSERT INTO leky VALUES(seq_leky.nextval,'MMopril',533);
INSERT INTO leky VALUES(seq_leky.nextval,'Myolastan',835);
INSERT INTO leky VALUES(seq_leky.nextval,'Nepla',698);
INSERT INTO leky VALUES(seq_leky.nextval,'Noradrenalin',1497);
INSERT INTO leky VALUES(seq_leky.nextval,'Olfen',1116);
INSERT INTO leky VALUES(seq_leky.nextval,'Osagrand',87);
INSERT INTO leky VALUES(seq_leky.nextval,'Panogastin',1019);
INSERT INTO leky VALUES(seq_leky.nextval,'Phaenya 21',604);
INSERT INTO leky VALUES(seq_leky.nextval,'Praxbind',1168);
INSERT INTO leky VALUES(seq_leky.nextval,'ProstaXin',956);
INSERT INTO leky VALUES(seq_leky.nextval,'Ramizek',997);
INSERT INTO leky VALUES(seq_leky.nextval,'Rennie',1027);
INSERT INTO leky VALUES(seq_leky.nextval,'Ristfor',805);
INSERT INTO leky VALUES(seq_leky.nextval,'Sagilia',661);
INSERT INTO leky VALUES(seq_leky.nextval,'Setinin',812);
INSERT INTO leky VALUES(seq_leky.nextval,'Solampti',119);
INSERT INTO leky VALUES(seq_leky.nextval,'Stadapress',711);
INSERT INTO leky VALUES(seq_leky.nextval,'Sustiva',937);
INSERT INTO leky VALUES(seq_leky.nextval,'Tasmar',998);
INSERT INTO leky VALUES(seq_leky.nextval,'Tezeo HCT',1079);
INSERT INTO leky VALUES(seq_leky.nextval,'Torri',534);
INSERT INTO leky VALUES(seq_leky.nextval,'Tropivent',105);
INSERT INTO leky VALUES(seq_leky.nextval,'Ursofalk',1049);
INSERT INTO leky VALUES(seq_leky.nextval,'Velavel',1136);
INSERT INTO leky VALUES(seq_leky.nextval,'Vidonorm',1008);
INSERT INTO leky VALUES(seq_leky.nextval,'Xadago',486);
INSERT INTO leky VALUES(seq_leky.nextval,'Zaracet',701);
INSERT INTO leky VALUES(seq_leky.nextval,'Zolafren',887);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY dodavatele
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Barnys',1,TO_DATE('2006-06-15','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Schwabe Czech Republic, s.r.o.',0,NULL,TO_DATE('2016-03-12','YYYY-MM-DD'),TO_DATE('2016-03-12','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'FAVEA, spol. s r. o.',0,NULL,TO_DATE('2008-07-04','YYYY-MM-DD'),TO_DATE('2008-07-04','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'PHOENIX lekarensky velkoobchod, a.s.',1,TO_DATE('2013-03-18','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'IBI-International spol. s r.o.',1,TO_DATE('2008-09-28','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Interpharma Praha, a.s.',1,TO_DATE('2012-06-18','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'NOVIKO a.s.',1,TO_DATE('2005-07-29','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Alliance Healthcare s.r.o.',1,TO_DATE('2005-04-15','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Dr. Peithner Prag s.r.o.',0,NULL,TO_DATE('2012-08-03','YYYY-MM-DD'),TO_DATE('2012-08-03','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Pfizer, spol. s r.o.',0,NULL,TO_DATE('2008-07-05','YYYY-MM-DD'),TO_DATE('2008-07-05','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Wyeth Whitehall Czech s.r.o.',1,TO_DATE('2006-07-06','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Glenmark Pharmaceuticals s.r.o.',1,TO_DATE('2009-09-29','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'PANEP s.r.o.',0,NULL,TO_DATE('2010-02-07','YYYY-MM-DD'),TO_DATE('2010-02-07','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'MERCK spol. s r.o.',0,NULL,TO_DATE('2007-06-02','YYYY-MM-DD'),TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'EXBIO Praha, a.s.',1,TO_DATE('2015-09-19','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Fresenius Kabi s.r.o.',1,TO_DATE('2010-04-21','YYYY-MM-DD'),NULL,NULL);
INSERT INTO dodavatele VALUES(seq_dodavatele.nextval,'Medicom International s.r.o.',1,TO_DATE('2016-11-25','YYYY-MM-DD'),NULL,NULL);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY POBOCKY
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Afrodite','Porici','5','Brno',63900);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Nemesis','Technicka','3058/10','Brno',61600);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Peitho','Purkynova','464/118','Brno',61200);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Pothos','Bozetechova','2', 'Brno',61266);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Themis','Kolejni','2906/4','Brno',61200);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Tyche','Veveru','331/95','Brno',60200);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Asklepios','Technicka','2896/2','Brno',61669);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Dionysos','Udolni','244/53','Brno',60200);
INSERT INTO pobocky VALUES(seq_pobocky.nextval, 'Eros','Purkynova','464/118','Brno',61200);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY REZERVACE
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Maly Princ',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Paul Baumer',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Hamlet Dansky',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Pavel Herout',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Anna Karenina',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Marina Sladkovicova',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Juraj Janosik',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Pacho Hybsky',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Holden Claufield',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Maco Mliec',TO_DATE('2007-06-02','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamek',TO_DATE('2008-08-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamcova',TO_DATE('2009-04-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamec',TO_DATE('2005-04-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adam',TO_DATE('2014-08-10','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamova',TO_DATE('2005-06-17','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andel',TO_DATE('2011-04-2','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andelova',TO_DATE('2014-05-23','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrlova',TO_DATE('2008-08-1','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrle',TO_DATE('2012-04-5','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Albrecht',TO_DATE('2010-06-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Albrechtova',TO_DATE('2007-08-4','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambroz',TO_DATE('2012-04-10','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambrozova',TO_DATE('2012-05-2','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrysek',TO_DATE('2009-01-1','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andryskova',TO_DATE('2012-02-4','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamcik',TO_DATE('2012-01-11','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Alexova',TO_DATE('2011-09-17','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Alexa',TO_DATE('2007-09-22','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamcikova',TO_DATE('2005-01-4','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrlik',TO_DATE('2008-02-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Anderlova',TO_DATE('2012-07-2','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrlikova',TO_DATE('2016-04-15','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Altman',TO_DATE('2008-05-27','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Anderle',TO_DATE('2011-09-17','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Altmanova',TO_DATE('2008-08-8','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamik',TO_DATE('2012-06-15','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abraham',TO_DATE('2012-02-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamikova',TO_DATE('2015-04-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Absolonova',TO_DATE('2009-05-26','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Absolon',TO_DATE('2012-08-25','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antl',TO_DATE('2013-07-17','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrs',TO_DATE('2011-06-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abrahamova',TO_DATE('2009-02-7','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrsova',TO_DATE('2010-03-22','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abrahamova',TO_DATE('2016-07-6','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abraham',TO_DATE('2006-06-24','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Albert',TO_DATE('2010-04-5','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antlova',TO_DATE('2009-08-17','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Albertova',TO_DATE('2005-03-14','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andres',TO_DATE('2009-07-21','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andresova',TO_DATE('2016-07-19','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antonin',TO_DATE('2006-04-22','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antalova',TO_DATE('2008-06-8','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamus',TO_DATE('2006-01-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adlerova',TO_DATE('2007-05-25','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adler',TO_DATE('2005-01-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamusova',TO_DATE('2014-09-26','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antoninova',TO_DATE('2013-02-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Anton',TO_DATE('2013-09-21','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Antal',TO_DATE('2013-08-28','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Altmann',TO_DATE('2008-05-27','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambros',TO_DATE('2009-01-10','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamovsky',TO_DATE('2015-01-14','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamovska',TO_DATE('2008-02-1','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambrosova',TO_DATE('2009-05-4','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambroz',TO_DATE('2012-02-25','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambrozova',TO_DATE('2009-07-18','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Altmannova',TO_DATE('2016-04-4','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Albl',TO_DATE('2015-08-7','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Alblova',TO_DATE('2016-06-15','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ales',TO_DATE('2007-02-21','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Alesova',TO_DATE('2008-05-18','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Anders',TO_DATE('2007-09-7','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ali',TO_DATE('2015-03-8','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abrham',TO_DATE('2014-02-15','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Abrhamova',TO_DATE('2010-01-16','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Alt',TO_DATE('2007-06-3','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Altova',TO_DATE('2006-01-14','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adolf',TO_DATE('2008-03-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adamczyk',TO_DATE('2011-02-5','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andersova',TO_DATE('2006-03-28','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Angelov',TO_DATE('2016-08-27','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Adolfova',TO_DATE('2011-09-12','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Ambrozek',TO_DATE('2009-06-2','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Androva',TO_DATE('2015-03-7','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrys',TO_DATE('2012-05-28','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andrys',TO_DATE('2016-01-26','YYYY-MM-DD'));
INSERT INTO rezervace VALUES(seq_rezervace.nextval,'Andr',TO_DATE('2006-09-12','YYYY-MM-DD'));


--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY REZERVACE_LEKY
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------

INSERT INTO rezervace_leky VALUES(1,1);
INSERT INTO rezervace_leky VALUES(1,2);
INSERT INTO rezervace_leky VALUES(1,3);
INSERT INTO rezervace_leky VALUES(1,4);
INSERT INTO rezervace_leky VALUES(1,5);
INSERT INTO rezervace_leky VALUES(4,6);
INSERT INTO rezervace_leky VALUES(5,7);
INSERT INTO rezervace_leky VALUES(3,8);
INSERT INTO rezervace_leky VALUES(1,9);
INSERT INTO rezervace_leky VALUES(2,10);
INSERT INTO rezervace_leky VALUES(25,11);
INSERT INTO rezervace_leky VALUES(10,12);
INSERT INTO rezervace_leky VALUES(58,13);
INSERT INTO rezervace_leky VALUES(26,14);
INSERT INTO rezervace_leky VALUES(41,15);
INSERT INTO rezervace_leky VALUES(3,16);
INSERT INTO rezervace_leky VALUES(30,17);
INSERT INTO rezervace_leky VALUES(64,18);
INSERT INTO rezervace_leky VALUES(39,19);
INSERT INTO rezervace_leky VALUES(9,20);
INSERT INTO rezervace_leky VALUES(17,21);
INSERT INTO rezervace_leky VALUES(14,22);
INSERT INTO rezervace_leky VALUES(64,23);
INSERT INTO rezervace_leky VALUES(10,24);
INSERT INTO rezervace_leky VALUES(5,25);
INSERT INTO rezervace_leky VALUES(31,26);
INSERT INTO rezervace_leky VALUES(53,27);
INSERT INTO rezervace_leky VALUES(36,28);
INSERT INTO rezervace_leky VALUES(22,29);
INSERT INTO rezervace_leky VALUES(9,30);
INSERT INTO rezervace_leky VALUES(23,31);
INSERT INTO rezervace_leky VALUES(54,32);
INSERT INTO rezervace_leky VALUES(28,33);
INSERT INTO rezervace_leky VALUES(49,34);
INSERT INTO rezervace_leky VALUES(44,35);
INSERT INTO rezervace_leky VALUES(56,36);
INSERT INTO rezervace_leky VALUES(45,37);
INSERT INTO rezervace_leky VALUES(5,38);
INSERT INTO rezervace_leky VALUES(22,39);
INSERT INTO rezervace_leky VALUES(8,40);
INSERT INTO rezervace_leky VALUES(65,41);
INSERT INTO rezervace_leky VALUES(25,42);
INSERT INTO rezervace_leky VALUES(42,43);
INSERT INTO rezervace_leky VALUES(32,44);
INSERT INTO rezervace_leky VALUES(27,45);
INSERT INTO rezervace_leky VALUES(13,46);
INSERT INTO rezervace_leky VALUES(8,47);
INSERT INTO rezervace_leky VALUES(59,48);
INSERT INTO rezervace_leky VALUES(52,49);
INSERT INTO rezervace_leky VALUES(1,50);
INSERT INTO rezervace_leky VALUES(27,51);
INSERT INTO rezervace_leky VALUES(28,52);
INSERT INTO rezervace_leky VALUES(16,53);
INSERT INTO rezervace_leky VALUES(33,54);
INSERT INTO rezervace_leky VALUES(32,55);
INSERT INTO rezervace_leky VALUES(46,56);
INSERT INTO rezervace_leky VALUES(32,57);
INSERT INTO rezervace_leky VALUES(35,58);
INSERT INTO rezervace_leky VALUES(49,59);
INSERT INTO rezervace_leky VALUES(30,60);
INSERT INTO rezervace_leky VALUES(9,61);
INSERT INTO rezervace_leky VALUES(50,62);
INSERT INTO rezervace_leky VALUES(2,63);
INSERT INTO rezervace_leky VALUES(11,64);
INSERT INTO rezervace_leky VALUES(22,65);
INSERT INTO rezervace_leky VALUES(51,66);
INSERT INTO rezervace_leky VALUES(34,67);
INSERT INTO rezervace_leky VALUES(49,68);
INSERT INTO rezervace_leky VALUES(61,69);
INSERT INTO rezervace_leky VALUES(63,70);
INSERT INTO rezervace_leky VALUES(10,71);
INSERT INTO rezervace_leky VALUES(41,72);
INSERT INTO rezervace_leky VALUES(65,73);
INSERT INTO rezervace_leky VALUES(61,74);
INSERT INTO rezervace_leky VALUES(14,75);
INSERT INTO rezervace_leky VALUES(13,76);
INSERT INTO rezervace_leky VALUES(14,77);
INSERT INTO rezervace_leky VALUES(22,78);
INSERT INTO rezervace_leky VALUES(40,79);
INSERT INTO rezervace_leky VALUES(64,80);
INSERT INTO rezervace_leky VALUES(55,81);
INSERT INTO rezervace_leky VALUES(44,82);
INSERT INTO rezervace_leky VALUES(14,83);
INSERT INTO rezervace_leky VALUES(56,84);
INSERT INTO rezervace_leky VALUES(61,85);
INSERT INTO rezervace_leky VALUES(42,86);
INSERT INTO rezervace_leky VALUES(62,6);
INSERT INTO rezervace_leky VALUES(20,27);
INSERT INTO rezervace_leky VALUES(26,33);
INSERT INTO rezervace_leky VALUES(59,44);
INSERT INTO rezervace_leky VALUES(42,35);
INSERT INTO rezervace_leky VALUES(31,25);
INSERT INTO rezervace_leky VALUES(40,16);
INSERT INTO rezervace_leky VALUES(18,45);
INSERT INTO rezervace_leky VALUES(65,2);
INSERT INTO rezervace_leky VALUES(6,8);
INSERT INTO rezervace_leky VALUES(54,22);
INSERT INTO rezervace_leky VALUES(23,22);
INSERT INTO rezervace_leky VALUES(24,36);
INSERT INTO rezervace_leky VALUES(29,2);
INSERT INTO rezervace_leky VALUES(45,23);
INSERT INTO rezervace_leky VALUES(46,21);
INSERT INTO rezervace_leky VALUES(23,4);
INSERT INTO rezervace_leky VALUES(66,6);
INSERT INTO rezervace_leky VALUES(43,2);
INSERT INTO rezervace_leky VALUES(28,39);
INSERT INTO rezervace_leky VALUES(9,21);
INSERT INTO rezervace_leky VALUES(53,3);
INSERT INTO rezervace_leky VALUES(28,26);
INSERT INTO rezervace_leky VALUES(17,29);
INSERT INTO rezervace_leky VALUES(33,16);
INSERT INTO rezervace_leky VALUES(33,6);
INSERT INTO rezervace_leky VALUES(50,48);
INSERT INTO rezervace_leky VALUES(10,9);
INSERT INTO rezervace_leky VALUES(3,37);
INSERT INTO rezervace_leky VALUES(23,24);
INSERT INTO rezervace_leky VALUES(35,20);
INSERT INTO rezervace_leky VALUES(62,27);
INSERT INTO rezervace_leky VALUES(11,2);
INSERT INTO rezervace_leky VALUES(66,28);
INSERT INTO rezervace_leky VALUES(15,28);
INSERT INTO rezervace_leky VALUES(15,13);
INSERT INTO rezervace_leky VALUES(41,41);
INSERT INTO rezervace_leky VALUES(15,45);
INSERT INTO rezervace_leky VALUES(62,16);
INSERT INTO rezervace_leky VALUES(63,4);
INSERT INTO rezervace_leky VALUES(21,31);
INSERT INTO rezervace_leky VALUES(42,4);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY POJISTOVNY
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Vseobecna zdravotni pojistovna CR');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Vojenska zdravotni pojistovna CR');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Ceska prumyslova zdravotni pojistovna');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Oborova zdravotni poj. zam. bank, poj. a stav.');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Zamestnanecka pojistovna Skoda');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Zdravotni pojistovna ministerstva vnitra CR');
INSERT INTO pojistovny VALUES(seq_pojistovny.nextval,'Revirni bratrska pokladna, zdrav. pojistovna');

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY predpisy
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9507236607,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9651279946,3);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9205137667,5);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9511163948,1);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,8955147839,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9655053826,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9504210298,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9504071302,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,7409011126,4);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9651279946,5);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9205137667,5);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9511163948,6);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,8955147839,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9655053826,2);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9504210298,5);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,9504071302,5);
INSERT INTO predpisy VALUES(seq_predpisy.nextval,7409011126,2);


--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY predpisy_leky
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO predpisy_leky VALUES(66,1);
INSERT INTO predpisy_leky VALUES(17,2);
INSERT INTO predpisy_leky VALUES(60,3);
INSERT INTO predpisy_leky VALUES(66,4);
INSERT INTO predpisy_leky VALUES(23,5);
INSERT INTO predpisy_leky VALUES(7,6);
INSERT INTO predpisy_leky VALUES(16,7);
INSERT INTO predpisy_leky VALUES(58,8);
INSERT INTO predpisy_leky VALUES(24,9);
INSERT INTO predpisy_leky VALUES(30,10);
INSERT INTO predpisy_leky VALUES(12,11);
INSERT INTO predpisy_leky VALUES(3,12);
INSERT INTO predpisy_leky VALUES(67,13);
INSERT INTO predpisy_leky VALUES(58,14);
INSERT INTO predpisy_leky VALUES(66,15);
INSERT INTO predpisy_leky VALUES(15,16);
INSERT INTO predpisy_leky VALUES(66,17);


--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY leky_na_pobockach
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO leky_na_pobockach VALUES(48,1,1);
INSERT INTO leky_na_pobockach VALUES(8,1,2);
INSERT INTO leky_na_pobockach VALUES(196,1,3);
INSERT INTO leky_na_pobockach VALUES(67,1,4);
INSERT INTO leky_na_pobockach VALUES(200,1,5);
INSERT INTO leky_na_pobockach VALUES(72,1,6);
INSERT INTO leky_na_pobockach VALUES(14,1,7);
INSERT INTO leky_na_pobockach VALUES(10,1,8);
INSERT INTO leky_na_pobockach VALUES(177,1,9);
INSERT INTO leky_na_pobockach VALUES(18,1,10);
INSERT INTO leky_na_pobockach VALUES(152,1,11);
INSERT INTO leky_na_pobockach VALUES(25,1,12);
INSERT INTO leky_na_pobockach VALUES(154,1,13);
INSERT INTO leky_na_pobockach VALUES(194,1,14);
INSERT INTO leky_na_pobockach VALUES(76,1,15);
INSERT INTO leky_na_pobockach VALUES(197,1,16);
INSERT INTO leky_na_pobockach VALUES(123,1,17);
INSERT INTO leky_na_pobockach VALUES(148,1,18);
INSERT INTO leky_na_pobockach VALUES(104,1,19);
INSERT INTO leky_na_pobockach VALUES(31,1,20);
INSERT INTO leky_na_pobockach VALUES(26,1,21);
INSERT INTO leky_na_pobockach VALUES(24,1,22);
INSERT INTO leky_na_pobockach VALUES(87,1,23);
INSERT INTO leky_na_pobockach VALUES(9,1,24);
INSERT INTO leky_na_pobockach VALUES(36,1,25);
INSERT INTO leky_na_pobockach VALUES(72,1,26);
INSERT INTO leky_na_pobockach VALUES(85,1,27);
INSERT INTO leky_na_pobockach VALUES(150,1,28);
INSERT INTO leky_na_pobockach VALUES(129,1,29);
INSERT INTO leky_na_pobockach VALUES(189,1,30);
INSERT INTO leky_na_pobockach VALUES(153,1,31);
INSERT INTO leky_na_pobockach VALUES(178,1,32);
INSERT INTO leky_na_pobockach VALUES(197,1,33);
INSERT INTO leky_na_pobockach VALUES(149,1,34);
INSERT INTO leky_na_pobockach VALUES(44,1,35);
INSERT INTO leky_na_pobockach VALUES(196,1,36);
INSERT INTO leky_na_pobockach VALUES(20,1,37);
INSERT INTO leky_na_pobockach VALUES(59,1,38);
INSERT INTO leky_na_pobockach VALUES(5,1,39);
INSERT INTO leky_na_pobockach VALUES(198,1,40);
INSERT INTO leky_na_pobockach VALUES(77,1,41);
INSERT INTO leky_na_pobockach VALUES(158,1,42);
INSERT INTO leky_na_pobockach VALUES(22,1,43);
INSERT INTO leky_na_pobockach VALUES(31,1,44);
INSERT INTO leky_na_pobockach VALUES(151,1,45);
INSERT INTO leky_na_pobockach VALUES(98,1,46);
INSERT INTO leky_na_pobockach VALUES(28,1,47);
INSERT INTO leky_na_pobockach VALUES(74,1,48);
INSERT INTO leky_na_pobockach VALUES(46,1,49);
INSERT INTO leky_na_pobockach VALUES(132,1,50);
INSERT INTO leky_na_pobockach VALUES(105,1,51);
INSERT INTO leky_na_pobockach VALUES(73,1,52);
INSERT INTO leky_na_pobockach VALUES(157,1,53);
INSERT INTO leky_na_pobockach VALUES(193,1,54);
INSERT INTO leky_na_pobockach VALUES(82,1,55);
INSERT INTO leky_na_pobockach VALUES(193,1,56);
INSERT INTO leky_na_pobockach VALUES(65,1,57);
INSERT INTO leky_na_pobockach VALUES(168,1,58);
INSERT INTO leky_na_pobockach VALUES(143,1,59);
INSERT INTO leky_na_pobockach VALUES(194,1,60);
INSERT INTO leky_na_pobockach VALUES(156,1,61);
INSERT INTO leky_na_pobockach VALUES(96,1,62);
INSERT INTO leky_na_pobockach VALUES(171,1,63);
INSERT INTO leky_na_pobockach VALUES(152,1,64);
INSERT INTO leky_na_pobockach VALUES(44,1,65);
INSERT INTO leky_na_pobockach VALUES(15,1,66);
INSERT INTO leky_na_pobockach VALUES(148,2,1);
INSERT INTO leky_na_pobockach VALUES(65,2,2);
INSERT INTO leky_na_pobockach VALUES(74,2,3);
INSERT INTO leky_na_pobockach VALUES(154,2,4);
INSERT INTO leky_na_pobockach VALUES(62,2,5);
INSERT INTO leky_na_pobockach VALUES(152,2,6);
INSERT INTO leky_na_pobockach VALUES(111,2,7);
INSERT INTO leky_na_pobockach VALUES(85,2,8);
INSERT INTO leky_na_pobockach VALUES(183,2,9);
INSERT INTO leky_na_pobockach VALUES(62,2,10);
INSERT INTO leky_na_pobockach VALUES(184,2,11);
INSERT INTO leky_na_pobockach VALUES(11,2,12);
INSERT INTO leky_na_pobockach VALUES(136,2,13);
INSERT INTO leky_na_pobockach VALUES(29,2,14);
INSERT INTO leky_na_pobockach VALUES(143,2,15);
INSERT INTO leky_na_pobockach VALUES(41,2,16);
INSERT INTO leky_na_pobockach VALUES(102,2,17);
INSERT INTO leky_na_pobockach VALUES(99,2,18);
INSERT INTO leky_na_pobockach VALUES(33,2,19);
INSERT INTO leky_na_pobockach VALUES(184,2,20);
INSERT INTO leky_na_pobockach VALUES(92,2,21);
INSERT INTO leky_na_pobockach VALUES(98,2,22);
INSERT INTO leky_na_pobockach VALUES(151,2,23);
INSERT INTO leky_na_pobockach VALUES(34,2,24);
INSERT INTO leky_na_pobockach VALUES(92,2,25);
INSERT INTO leky_na_pobockach VALUES(107,2,26);
INSERT INTO leky_na_pobockach VALUES(130,2,27);
INSERT INTO leky_na_pobockach VALUES(63,2,28);
INSERT INTO leky_na_pobockach VALUES(58,2,29);
INSERT INTO leky_na_pobockach VALUES(175,2,30);
INSERT INTO leky_na_pobockach VALUES(79,2,31);
INSERT INTO leky_na_pobockach VALUES(6,2,32);
INSERT INTO leky_na_pobockach VALUES(40,2,33);
INSERT INTO leky_na_pobockach VALUES(153,2,34);
INSERT INTO leky_na_pobockach VALUES(160,2,35);
INSERT INTO leky_na_pobockach VALUES(102,2,36);
INSERT INTO leky_na_pobockach VALUES(105,2,37);
INSERT INTO leky_na_pobockach VALUES(71,2,38);
INSERT INTO leky_na_pobockach VALUES(188,2,39);
INSERT INTO leky_na_pobockach VALUES(88,2,40);
INSERT INTO leky_na_pobockach VALUES(133,2,41);
INSERT INTO leky_na_pobockach VALUES(171,2,42);
INSERT INTO leky_na_pobockach VALUES(99,2,43);
INSERT INTO leky_na_pobockach VALUES(68,2,44);
INSERT INTO leky_na_pobockach VALUES(200,2,45);
INSERT INTO leky_na_pobockach VALUES(42,2,46);
INSERT INTO leky_na_pobockach VALUES(110,2,47);
INSERT INTO leky_na_pobockach VALUES(102,2,48);
INSERT INTO leky_na_pobockach VALUES(141,2,49);
INSERT INTO leky_na_pobockach VALUES(144,2,50);
INSERT INTO leky_na_pobockach VALUES(86,2,51);
INSERT INTO leky_na_pobockach VALUES(33,2,52);
INSERT INTO leky_na_pobockach VALUES(42,2,53);
INSERT INTO leky_na_pobockach VALUES(37,2,54);
INSERT INTO leky_na_pobockach VALUES(67,2,55);
INSERT INTO leky_na_pobockach VALUES(134,2,56);
INSERT INTO leky_na_pobockach VALUES(144,2,57);
INSERT INTO leky_na_pobockach VALUES(198,2,58);
INSERT INTO leky_na_pobockach VALUES(197,2,59);
INSERT INTO leky_na_pobockach VALUES(2,2,60);
INSERT INTO leky_na_pobockach VALUES(172,2,61);
INSERT INTO leky_na_pobockach VALUES(75,2,62);
INSERT INTO leky_na_pobockach VALUES(8,2,63);
INSERT INTO leky_na_pobockach VALUES(11,2,64);
INSERT INTO leky_na_pobockach VALUES(28,2,65);
INSERT INTO leky_na_pobockach VALUES(168,2,66);
INSERT INTO leky_na_pobockach VALUES(114,3,1);
INSERT INTO leky_na_pobockach VALUES(134,3,2);
INSERT INTO leky_na_pobockach VALUES(39,3,3);
INSERT INTO leky_na_pobockach VALUES(101,3,4);
INSERT INTO leky_na_pobockach VALUES(21,3,5);
INSERT INTO leky_na_pobockach VALUES(172,3,6);
INSERT INTO leky_na_pobockach VALUES(72,3,7);
INSERT INTO leky_na_pobockach VALUES(121,3,8);
INSERT INTO leky_na_pobockach VALUES(40,3,9);
INSERT INTO leky_na_pobockach VALUES(72,3,10);
INSERT INTO leky_na_pobockach VALUES(163,3,11);
INSERT INTO leky_na_pobockach VALUES(150,3,12);
INSERT INTO leky_na_pobockach VALUES(174,3,13);
INSERT INTO leky_na_pobockach VALUES(104,3,14);
INSERT INTO leky_na_pobockach VALUES(93,3,15);
INSERT INTO leky_na_pobockach VALUES(60,3,16);
INSERT INTO leky_na_pobockach VALUES(137,3,17);
INSERT INTO leky_na_pobockach VALUES(135,3,18);
INSERT INTO leky_na_pobockach VALUES(97,3,19);
INSERT INTO leky_na_pobockach VALUES(3,3,20);
INSERT INTO leky_na_pobockach VALUES(69,3,21);
INSERT INTO leky_na_pobockach VALUES(40,3,22);
INSERT INTO leky_na_pobockach VALUES(0,3,23);
INSERT INTO leky_na_pobockach VALUES(66,3,24);
INSERT INTO leky_na_pobockach VALUES(42,3,25);
INSERT INTO leky_na_pobockach VALUES(173,3,26);
INSERT INTO leky_na_pobockach VALUES(142,3,27);
INSERT INTO leky_na_pobockach VALUES(51,3,28);
INSERT INTO leky_na_pobockach VALUES(185,3,29);
INSERT INTO leky_na_pobockach VALUES(170,3,30);
INSERT INTO leky_na_pobockach VALUES(19,3,31);
INSERT INTO leky_na_pobockach VALUES(98,3,32);
INSERT INTO leky_na_pobockach VALUES(104,3,33);
INSERT INTO leky_na_pobockach VALUES(58,3,34);
INSERT INTO leky_na_pobockach VALUES(200,3,35);
INSERT INTO leky_na_pobockach VALUES(126,3,36);
INSERT INTO leky_na_pobockach VALUES(29,3,37);
INSERT INTO leky_na_pobockach VALUES(72,3,38);
INSERT INTO leky_na_pobockach VALUES(46,3,39);
INSERT INTO leky_na_pobockach VALUES(70,3,40);
INSERT INTO leky_na_pobockach VALUES(144,3,41);
INSERT INTO leky_na_pobockach VALUES(8,3,42);
INSERT INTO leky_na_pobockach VALUES(19,3,43);
INSERT INTO leky_na_pobockach VALUES(118,3,44);
INSERT INTO leky_na_pobockach VALUES(112,3,45);
INSERT INTO leky_na_pobockach VALUES(113,3,46);
INSERT INTO leky_na_pobockach VALUES(178,3,47);
INSERT INTO leky_na_pobockach VALUES(49,3,48);
INSERT INTO leky_na_pobockach VALUES(48,3,49);
INSERT INTO leky_na_pobockach VALUES(75,3,50);
INSERT INTO leky_na_pobockach VALUES(52,3,51);
INSERT INTO leky_na_pobockach VALUES(118,3,52);
INSERT INTO leky_na_pobockach VALUES(116,3,53);
INSERT INTO leky_na_pobockach VALUES(53,3,54);
INSERT INTO leky_na_pobockach VALUES(184,3,55);
INSERT INTO leky_na_pobockach VALUES(158,3,56);
INSERT INTO leky_na_pobockach VALUES(26,3,57);
INSERT INTO leky_na_pobockach VALUES(125,3,58);
INSERT INTO leky_na_pobockach VALUES(8,3,59);
INSERT INTO leky_na_pobockach VALUES(10,3,60);
INSERT INTO leky_na_pobockach VALUES(95,3,61);
INSERT INTO leky_na_pobockach VALUES(27,3,62);
INSERT INTO leky_na_pobockach VALUES(108,3,63);
INSERT INTO leky_na_pobockach VALUES(199,3,64);
INSERT INTO leky_na_pobockach VALUES(86,3,65);
INSERT INTO leky_na_pobockach VALUES(108,3,66);
INSERT INTO leky_na_pobockach VALUES(124,4,1);
INSERT INTO leky_na_pobockach VALUES(115,4,2);
INSERT INTO leky_na_pobockach VALUES(180,4,3);
INSERT INTO leky_na_pobockach VALUES(171,4,4);
INSERT INTO leky_na_pobockach VALUES(185,4,5);
INSERT INTO leky_na_pobockach VALUES(124,4,6);
INSERT INTO leky_na_pobockach VALUES(179,4,7);
INSERT INTO leky_na_pobockach VALUES(4,4,8);
INSERT INTO leky_na_pobockach VALUES(41,4,9);
INSERT INTO leky_na_pobockach VALUES(91,4,10);
INSERT INTO leky_na_pobockach VALUES(118,4,11);
INSERT INTO leky_na_pobockach VALUES(19,4,12);
INSERT INTO leky_na_pobockach VALUES(140,4,13);
INSERT INTO leky_na_pobockach VALUES(167,4,14);
INSERT INTO leky_na_pobockach VALUES(94,4,15);
INSERT INTO leky_na_pobockach VALUES(193,4,16);
INSERT INTO leky_na_pobockach VALUES(84,4,17);
INSERT INTO leky_na_pobockach VALUES(9,4,18);
INSERT INTO leky_na_pobockach VALUES(46,4,19);
INSERT INTO leky_na_pobockach VALUES(67,4,20);
INSERT INTO leky_na_pobockach VALUES(168,4,21);
INSERT INTO leky_na_pobockach VALUES(72,4,22);
INSERT INTO leky_na_pobockach VALUES(193,4,23);
INSERT INTO leky_na_pobockach VALUES(177,4,24);
INSERT INTO leky_na_pobockach VALUES(82,4,25);
INSERT INTO leky_na_pobockach VALUES(87,4,26);
INSERT INTO leky_na_pobockach VALUES(4,4,27);
INSERT INTO leky_na_pobockach VALUES(191,4,28);
INSERT INTO leky_na_pobockach VALUES(86,4,29);
INSERT INTO leky_na_pobockach VALUES(90,4,30);
INSERT INTO leky_na_pobockach VALUES(98,4,31);
INSERT INTO leky_na_pobockach VALUES(10,4,32);
INSERT INTO leky_na_pobockach VALUES(5,4,33);
INSERT INTO leky_na_pobockach VALUES(78,4,34);
INSERT INTO leky_na_pobockach VALUES(181,4,35);
INSERT INTO leky_na_pobockach VALUES(190,4,36);
INSERT INTO leky_na_pobockach VALUES(1,4,37);
INSERT INTO leky_na_pobockach VALUES(159,4,38);
INSERT INTO leky_na_pobockach VALUES(195,4,39);
INSERT INTO leky_na_pobockach VALUES(42,4,40);
INSERT INTO leky_na_pobockach VALUES(50,4,41);
INSERT INTO leky_na_pobockach VALUES(112,4,42);
INSERT INTO leky_na_pobockach VALUES(62,4,43);
INSERT INTO leky_na_pobockach VALUES(190,4,44);
INSERT INTO leky_na_pobockach VALUES(78,4,45);
INSERT INTO leky_na_pobockach VALUES(156,4,46);
INSERT INTO leky_na_pobockach VALUES(183,4,47);
INSERT INTO leky_na_pobockach VALUES(163,4,48);
INSERT INTO leky_na_pobockach VALUES(166,4,49);
INSERT INTO leky_na_pobockach VALUES(28,4,50);
INSERT INTO leky_na_pobockach VALUES(29,4,51);
INSERT INTO leky_na_pobockach VALUES(133,4,52);
INSERT INTO leky_na_pobockach VALUES(100,4,53);
INSERT INTO leky_na_pobockach VALUES(21,4,54);
INSERT INTO leky_na_pobockach VALUES(110,4,55);
INSERT INTO leky_na_pobockach VALUES(182,4,56);
INSERT INTO leky_na_pobockach VALUES(109,4,57);
INSERT INTO leky_na_pobockach VALUES(114,4,58);
INSERT INTO leky_na_pobockach VALUES(172,4,59);
INSERT INTO leky_na_pobockach VALUES(195,4,60);
INSERT INTO leky_na_pobockach VALUES(4,4,61);
INSERT INTO leky_na_pobockach VALUES(70,4,62);
INSERT INTO leky_na_pobockach VALUES(4,4,63);
INSERT INTO leky_na_pobockach VALUES(9,4,64);
INSERT INTO leky_na_pobockach VALUES(148,4,65);
INSERT INTO leky_na_pobockach VALUES(185,4,66);
INSERT INTO leky_na_pobockach VALUES(200,5,1);
INSERT INTO leky_na_pobockach VALUES(149,5,2);
INSERT INTO leky_na_pobockach VALUES(144,5,3);
INSERT INTO leky_na_pobockach VALUES(195,5,4);
INSERT INTO leky_na_pobockach VALUES(192,5,5);
INSERT INTO leky_na_pobockach VALUES(194,5,6);
INSERT INTO leky_na_pobockach VALUES(106,5,7);
INSERT INTO leky_na_pobockach VALUES(53,5,8);
INSERT INTO leky_na_pobockach VALUES(184,5,9);
INSERT INTO leky_na_pobockach VALUES(185,5,10);
INSERT INTO leky_na_pobockach VALUES(8,5,11);
INSERT INTO leky_na_pobockach VALUES(166,5,12);
INSERT INTO leky_na_pobockach VALUES(148,5,13);
INSERT INTO leky_na_pobockach VALUES(175,5,14);
INSERT INTO leky_na_pobockach VALUES(195,5,15);
INSERT INTO leky_na_pobockach VALUES(177,5,16);
INSERT INTO leky_na_pobockach VALUES(108,5,17);
INSERT INTO leky_na_pobockach VALUES(94,5,18);
INSERT INTO leky_na_pobockach VALUES(199,5,19);
INSERT INTO leky_na_pobockach VALUES(17,5,20);
INSERT INTO leky_na_pobockach VALUES(76,5,21);
INSERT INTO leky_na_pobockach VALUES(107,5,22);
INSERT INTO leky_na_pobockach VALUES(132,5,23);
INSERT INTO leky_na_pobockach VALUES(47,5,24);
INSERT INTO leky_na_pobockach VALUES(102,5,25);
INSERT INTO leky_na_pobockach VALUES(136,5,26);
INSERT INTO leky_na_pobockach VALUES(118,5,27);
INSERT INTO leky_na_pobockach VALUES(107,5,28);
INSERT INTO leky_na_pobockach VALUES(146,5,29);
INSERT INTO leky_na_pobockach VALUES(65,5,30);
INSERT INTO leky_na_pobockach VALUES(92,5,31);
INSERT INTO leky_na_pobockach VALUES(145,5,32);
INSERT INTO leky_na_pobockach VALUES(13,5,33);
INSERT INTO leky_na_pobockach VALUES(35,5,34);
INSERT INTO leky_na_pobockach VALUES(139,5,35);
INSERT INTO leky_na_pobockach VALUES(4,5,36);
INSERT INTO leky_na_pobockach VALUES(29,5,37);
INSERT INTO leky_na_pobockach VALUES(45,5,38);
INSERT INTO leky_na_pobockach VALUES(58,5,39);
INSERT INTO leky_na_pobockach VALUES(13,5,40);
INSERT INTO leky_na_pobockach VALUES(30,5,41);
INSERT INTO leky_na_pobockach VALUES(66,5,42);
INSERT INTO leky_na_pobockach VALUES(180,5,43);
INSERT INTO leky_na_pobockach VALUES(178,5,44);
INSERT INTO leky_na_pobockach VALUES(41,5,45);
INSERT INTO leky_na_pobockach VALUES(174,5,46);
INSERT INTO leky_na_pobockach VALUES(155,5,47);
INSERT INTO leky_na_pobockach VALUES(149,5,48);
INSERT INTO leky_na_pobockach VALUES(68,5,49);
INSERT INTO leky_na_pobockach VALUES(154,5,50);
INSERT INTO leky_na_pobockach VALUES(167,5,51);
INSERT INTO leky_na_pobockach VALUES(144,5,52);
INSERT INTO leky_na_pobockach VALUES(61,5,53);
INSERT INTO leky_na_pobockach VALUES(98,5,54);
INSERT INTO leky_na_pobockach VALUES(192,5,55);
INSERT INTO leky_na_pobockach VALUES(163,5,56);
INSERT INTO leky_na_pobockach VALUES(34,5,57);
INSERT INTO leky_na_pobockach VALUES(109,5,58);
INSERT INTO leky_na_pobockach VALUES(70,5,59);
INSERT INTO leky_na_pobockach VALUES(180,5,60);
INSERT INTO leky_na_pobockach VALUES(175,5,61);
INSERT INTO leky_na_pobockach VALUES(162,5,62);
INSERT INTO leky_na_pobockach VALUES(124,5,63);
INSERT INTO leky_na_pobockach VALUES(188,5,64);
INSERT INTO leky_na_pobockach VALUES(198,5,65);
INSERT INTO leky_na_pobockach VALUES(63,5,66);
INSERT INTO leky_na_pobockach VALUES(193,6,1);
INSERT INTO leky_na_pobockach VALUES(27,6,2);
INSERT INTO leky_na_pobockach VALUES(109,6,3);
INSERT INTO leky_na_pobockach VALUES(50,6,4);
INSERT INTO leky_na_pobockach VALUES(40,6,5);
INSERT INTO leky_na_pobockach VALUES(139,6,6);
INSERT INTO leky_na_pobockach VALUES(117,6,7);
INSERT INTO leky_na_pobockach VALUES(20,6,8);
INSERT INTO leky_na_pobockach VALUES(117,6,9);
INSERT INTO leky_na_pobockach VALUES(159,6,10);
INSERT INTO leky_na_pobockach VALUES(195,6,11);
INSERT INTO leky_na_pobockach VALUES(71,6,12);
INSERT INTO leky_na_pobockach VALUES(107,6,13);
INSERT INTO leky_na_pobockach VALUES(62,6,14);
INSERT INTO leky_na_pobockach VALUES(24,6,15);
INSERT INTO leky_na_pobockach VALUES(73,6,16);
INSERT INTO leky_na_pobockach VALUES(6,6,17);
INSERT INTO leky_na_pobockach VALUES(85,6,18);
INSERT INTO leky_na_pobockach VALUES(172,6,19);
INSERT INTO leky_na_pobockach VALUES(199,6,20);
INSERT INTO leky_na_pobockach VALUES(48,6,21);
INSERT INTO leky_na_pobockach VALUES(5,6,22);
INSERT INTO leky_na_pobockach VALUES(108,6,23);
INSERT INTO leky_na_pobockach VALUES(118,6,24);
INSERT INTO leky_na_pobockach VALUES(185,6,25);
INSERT INTO leky_na_pobockach VALUES(82,6,26);
INSERT INTO leky_na_pobockach VALUES(79,6,27);
INSERT INTO leky_na_pobockach VALUES(109,6,28);
INSERT INTO leky_na_pobockach VALUES(70,6,29);
INSERT INTO leky_na_pobockach VALUES(76,6,30);
INSERT INTO leky_na_pobockach VALUES(173,6,31);
INSERT INTO leky_na_pobockach VALUES(62,6,32);
INSERT INTO leky_na_pobockach VALUES(103,6,33);
INSERT INTO leky_na_pobockach VALUES(81,6,34);
INSERT INTO leky_na_pobockach VALUES(113,6,35);
INSERT INTO leky_na_pobockach VALUES(144,6,36);
INSERT INTO leky_na_pobockach VALUES(20,6,37);
INSERT INTO leky_na_pobockach VALUES(30,6,38);
INSERT INTO leky_na_pobockach VALUES(164,6,39);
INSERT INTO leky_na_pobockach VALUES(137,6,40);
INSERT INTO leky_na_pobockach VALUES(189,6,41);
INSERT INTO leky_na_pobockach VALUES(158,6,42);
INSERT INTO leky_na_pobockach VALUES(8,6,43);
INSERT INTO leky_na_pobockach VALUES(96,6,44);
INSERT INTO leky_na_pobockach VALUES(20,6,45);
INSERT INTO leky_na_pobockach VALUES(33,6,46);
INSERT INTO leky_na_pobockach VALUES(169,6,47);
INSERT INTO leky_na_pobockach VALUES(27,6,48);
INSERT INTO leky_na_pobockach VALUES(118,6,49);
INSERT INTO leky_na_pobockach VALUES(141,6,50);
INSERT INTO leky_na_pobockach VALUES(25,6,51);
INSERT INTO leky_na_pobockach VALUES(167,6,52);
INSERT INTO leky_na_pobockach VALUES(146,6,53);
INSERT INTO leky_na_pobockach VALUES(133,6,54);
INSERT INTO leky_na_pobockach VALUES(84,6,55);
INSERT INTO leky_na_pobockach VALUES(131,6,56);
INSERT INTO leky_na_pobockach VALUES(15,6,57);
INSERT INTO leky_na_pobockach VALUES(164,6,58);
INSERT INTO leky_na_pobockach VALUES(40,6,59);
INSERT INTO leky_na_pobockach VALUES(85,6,60);
INSERT INTO leky_na_pobockach VALUES(40,6,61);
INSERT INTO leky_na_pobockach VALUES(13,6,62);
INSERT INTO leky_na_pobockach VALUES(148,6,63);
INSERT INTO leky_na_pobockach VALUES(144,6,64);
INSERT INTO leky_na_pobockach VALUES(94,6,65);
INSERT INTO leky_na_pobockach VALUES(60,6,66);
INSERT INTO leky_na_pobockach VALUES(87,7,1);
INSERT INTO leky_na_pobockach VALUES(115,7,2);
INSERT INTO leky_na_pobockach VALUES(91,7,3);
INSERT INTO leky_na_pobockach VALUES(51,7,4);
INSERT INTO leky_na_pobockach VALUES(51,7,5);
INSERT INTO leky_na_pobockach VALUES(79,7,6);
INSERT INTO leky_na_pobockach VALUES(9,7,7);
INSERT INTO leky_na_pobockach VALUES(59,7,8);
INSERT INTO leky_na_pobockach VALUES(175,7,9);
INSERT INTO leky_na_pobockach VALUES(29,7,10);
INSERT INTO leky_na_pobockach VALUES(93,7,11);
INSERT INTO leky_na_pobockach VALUES(144,7,12);
INSERT INTO leky_na_pobockach VALUES(57,7,13);
INSERT INTO leky_na_pobockach VALUES(10,7,14);
INSERT INTO leky_na_pobockach VALUES(85,7,15);
INSERT INTO leky_na_pobockach VALUES(82,7,16);
INSERT INTO leky_na_pobockach VALUES(178,7,17);
INSERT INTO leky_na_pobockach VALUES(30,7,18);
INSERT INTO leky_na_pobockach VALUES(15,7,19);
INSERT INTO leky_na_pobockach VALUES(61,7,20);
INSERT INTO leky_na_pobockach VALUES(162,7,21);
INSERT INTO leky_na_pobockach VALUES(30,7,22);
INSERT INTO leky_na_pobockach VALUES(25,7,23);
INSERT INTO leky_na_pobockach VALUES(2,7,24);
INSERT INTO leky_na_pobockach VALUES(116,7,25);
INSERT INTO leky_na_pobockach VALUES(65,7,26);
INSERT INTO leky_na_pobockach VALUES(15,7,27);
INSERT INTO leky_na_pobockach VALUES(63,7,28);
INSERT INTO leky_na_pobockach VALUES(8,7,29);
INSERT INTO leky_na_pobockach VALUES(110,7,30);
INSERT INTO leky_na_pobockach VALUES(124,7,31);
INSERT INTO leky_na_pobockach VALUES(96,7,32);
INSERT INTO leky_na_pobockach VALUES(24,7,33);
INSERT INTO leky_na_pobockach VALUES(14,7,34);
INSERT INTO leky_na_pobockach VALUES(147,7,35);
INSERT INTO leky_na_pobockach VALUES(75,7,36);
INSERT INTO leky_na_pobockach VALUES(93,7,37);
INSERT INTO leky_na_pobockach VALUES(156,7,38);
INSERT INTO leky_na_pobockach VALUES(135,7,39);
INSERT INTO leky_na_pobockach VALUES(68,7,40);
INSERT INTO leky_na_pobockach VALUES(186,7,41);
INSERT INTO leky_na_pobockach VALUES(27,7,42);
INSERT INTO leky_na_pobockach VALUES(12,7,43);
INSERT INTO leky_na_pobockach VALUES(42,7,44);
INSERT INTO leky_na_pobockach VALUES(38,7,45);
INSERT INTO leky_na_pobockach VALUES(97,7,46);
INSERT INTO leky_na_pobockach VALUES(125,7,47);
INSERT INTO leky_na_pobockach VALUES(15,7,48);
INSERT INTO leky_na_pobockach VALUES(128,7,49);
INSERT INTO leky_na_pobockach VALUES(141,7,50);
INSERT INTO leky_na_pobockach VALUES(77,7,51);
INSERT INTO leky_na_pobockach VALUES(89,7,52);
INSERT INTO leky_na_pobockach VALUES(172,7,53);
INSERT INTO leky_na_pobockach VALUES(103,7,54);
INSERT INTO leky_na_pobockach VALUES(92,7,55);
INSERT INTO leky_na_pobockach VALUES(87,7,56);
INSERT INTO leky_na_pobockach VALUES(168,7,57);
INSERT INTO leky_na_pobockach VALUES(107,7,58);
INSERT INTO leky_na_pobockach VALUES(150,7,59);
INSERT INTO leky_na_pobockach VALUES(177,7,60);
INSERT INTO leky_na_pobockach VALUES(16,7,61);
INSERT INTO leky_na_pobockach VALUES(73,7,62);
INSERT INTO leky_na_pobockach VALUES(72,7,63);
INSERT INTO leky_na_pobockach VALUES(40,7,64);
INSERT INTO leky_na_pobockach VALUES(87,7,65);
INSERT INTO leky_na_pobockach VALUES(18,7,66);
INSERT INTO leky_na_pobockach VALUES(116,8,1);
INSERT INTO leky_na_pobockach VALUES(181,8,2);
INSERT INTO leky_na_pobockach VALUES(175,8,3);
INSERT INTO leky_na_pobockach VALUES(50,8,4);
INSERT INTO leky_na_pobockach VALUES(48,8,5);
INSERT INTO leky_na_pobockach VALUES(161,8,6);
INSERT INTO leky_na_pobockach VALUES(78,8,7);
INSERT INTO leky_na_pobockach VALUES(61,8,8);
INSERT INTO leky_na_pobockach VALUES(3,8,9);
INSERT INTO leky_na_pobockach VALUES(117,8,10);
INSERT INTO leky_na_pobockach VALUES(158,8,11);
INSERT INTO leky_na_pobockach VALUES(128,8,12);
INSERT INTO leky_na_pobockach VALUES(133,8,13);
INSERT INTO leky_na_pobockach VALUES(85,8,14);
INSERT INTO leky_na_pobockach VALUES(68,8,15);
INSERT INTO leky_na_pobockach VALUES(9,8,16);
INSERT INTO leky_na_pobockach VALUES(174,8,17);
INSERT INTO leky_na_pobockach VALUES(39,8,18);
INSERT INTO leky_na_pobockach VALUES(113,8,19);
INSERT INTO leky_na_pobockach VALUES(65,8,20);
INSERT INTO leky_na_pobockach VALUES(127,8,21);
INSERT INTO leky_na_pobockach VALUES(80,8,22);
INSERT INTO leky_na_pobockach VALUES(173,8,23);
INSERT INTO leky_na_pobockach VALUES(76,8,24);
INSERT INTO leky_na_pobockach VALUES(56,8,25);
INSERT INTO leky_na_pobockach VALUES(189,8,26);
INSERT INTO leky_na_pobockach VALUES(150,8,27);
INSERT INTO leky_na_pobockach VALUES(129,8,28);
INSERT INTO leky_na_pobockach VALUES(29,8,29);
INSERT INTO leky_na_pobockach VALUES(37,8,30);
INSERT INTO leky_na_pobockach VALUES(147,8,31);
INSERT INTO leky_na_pobockach VALUES(145,8,32);
INSERT INTO leky_na_pobockach VALUES(17,8,33);
INSERT INTO leky_na_pobockach VALUES(122,8,34);
INSERT INTO leky_na_pobockach VALUES(196,8,35);
INSERT INTO leky_na_pobockach VALUES(66,8,36);
INSERT INTO leky_na_pobockach VALUES(82,8,37);
INSERT INTO leky_na_pobockach VALUES(73,8,38);
INSERT INTO leky_na_pobockach VALUES(127,8,39);
INSERT INTO leky_na_pobockach VALUES(85,8,40);
INSERT INTO leky_na_pobockach VALUES(190,8,41);
INSERT INTO leky_na_pobockach VALUES(84,8,42);
INSERT INTO leky_na_pobockach VALUES(13,8,43);
INSERT INTO leky_na_pobockach VALUES(122,8,44);
INSERT INTO leky_na_pobockach VALUES(169,8,45);
INSERT INTO leky_na_pobockach VALUES(82,8,46);
INSERT INTO leky_na_pobockach VALUES(132,8,47);
INSERT INTO leky_na_pobockach VALUES(143,8,48);
INSERT INTO leky_na_pobockach VALUES(122,8,49);
INSERT INTO leky_na_pobockach VALUES(44,8,50);
INSERT INTO leky_na_pobockach VALUES(8,8,51);
INSERT INTO leky_na_pobockach VALUES(48,8,52);
INSERT INTO leky_na_pobockach VALUES(125,8,53);
INSERT INTO leky_na_pobockach VALUES(182,8,54);
INSERT INTO leky_na_pobockach VALUES(125,8,55);
INSERT INTO leky_na_pobockach VALUES(182,8,56);
INSERT INTO leky_na_pobockach VALUES(170,8,57);
INSERT INTO leky_na_pobockach VALUES(74,8,58);
INSERT INTO leky_na_pobockach VALUES(110,8,59);
INSERT INTO leky_na_pobockach VALUES(200,8,60);
INSERT INTO leky_na_pobockach VALUES(111,8,61);
INSERT INTO leky_na_pobockach VALUES(57,8,62);
INSERT INTO leky_na_pobockach VALUES(144,8,63);
INSERT INTO leky_na_pobockach VALUES(129,8,64);
INSERT INTO leky_na_pobockach VALUES(179,8,65);
INSERT INTO leky_na_pobockach VALUES(139,8,66);


--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY prodane_leky
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('02/02/2007','DD/MM/YY'),1,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('12/03/2016','DD/MM/YY'),1,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('29/05/2006','DD/MM/YY'),1,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('25/01/2016','DD/MM/YY'),1,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('06/03/2008','DD/MM/YY'),1,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('02/03/2010','DD/MM/YY'),1,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('26/01/2009','DD/MM/YY'),1,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('25/11/2007','DD/MM/YY'),1,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('27/03/2012','DD/MM/YY'),1,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('06/07/2008','DD/MM/YY'),1,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('26/06/2009','DD/MM/YY'),1,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('28/08/2011','DD/MM/YY'),1,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('23/12/2009','DD/MM/YY'),1,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('09/08/2010','DD/MM/YY'),1,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('22/12/2015','DD/MM/YY'),1,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('27/06/2011','DD/MM/YY'),1,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('29/12/2016','DD/MM/YY'),1,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('22/06/2016','DD/MM/YY'),1,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('06/12/2007','DD/MM/YY'),1,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('21/01/2017','DD/MM/YY'),1,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('23/03/2007','DD/MM/YY'),1,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('04/08/2011','DD/MM/YY'),1,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('03/04/2015','DD/MM/YY'),2,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('02/03/2010','DD/MM/YY'),2,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('23/01/2012','DD/MM/YY'),2,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('21/07/2009','DD/MM/YY'),2,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('09/11/2013','DD/MM/YY'),2,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('02/01/2009','DD/MM/YY'),2,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('07/03/2009','DD/MM/YY'),2,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('30/01/2014','DD/MM/YY'),2,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('13/12/2016','DD/MM/YY'),2,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('02/10/2007','DD/MM/YY'),2,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('15/10/2012','DD/MM/YY'),2,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('19/11/2016','DD/MM/YY'),2,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('20/04/2016','DD/MM/YY'),2,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('05/08/2007','DD/MM/YY'),2,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('23/06/2009','DD/MM/YY'),2,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('01/08/2010','DD/MM/YY'),2,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('09/06/2009','DD/MM/YY'),2,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('03/10/2011','DD/MM/YY'),2,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('12/03/2010','DD/MM/YY'),2,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('23/10/2013','DD/MM/YY'),2,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('12/04/2013','DD/MM/YY'),2,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('03/06/2007','DD/MM/YY'),2,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('11/03/2013','DD/MM/YY'),3,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('25/02/2007','DD/MM/YY'),3,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('11/08/2006','DD/MM/YY'),3,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('25/05/2012','DD/MM/YY'),3,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('22/11/2009','DD/MM/YY'),3,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('18/11/2010','DD/MM/YY'),3,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('14/07/2011','DD/MM/YY'),3,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('02/04/2009','DD/MM/YY'),3,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('03/06/2008','DD/MM/YY'),3,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('02/07/2016','DD/MM/YY'),3,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('08/05/2011','DD/MM/YY'),3,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('14/02/2010','DD/MM/YY'),3,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('05/02/2009','DD/MM/YY'),3,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('10/05/2016','DD/MM/YY'),3,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('15/04/2006','DD/MM/YY'),3,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('09/08/2015','DD/MM/YY'),3,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('18/01/2016','DD/MM/YY'),3,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('26/02/2009','DD/MM/YY'),3,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('03/06/2008','DD/MM/YY'),3,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('25/10/2012','DD/MM/YY'),3,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('16/05/2010','DD/MM/YY'),3,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('10/04/2015','DD/MM/YY'),3,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('08/12/2012','DD/MM/YY'),4,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('05/09/2013','DD/MM/YY'),4,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('14/02/2015','DD/MM/YY'),4,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('25/12/2009','DD/MM/YY'),4,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('29/09/2006','DD/MM/YY'),4,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('20/07/2007','DD/MM/YY'),4,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('22/10/2014','DD/MM/YY'),4,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('25/12/2008','DD/MM/YY'),4,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('22/03/2007','DD/MM/YY'),4,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('03/05/2011','DD/MM/YY'),4,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('18/11/2006','DD/MM/YY'),4,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('08/09/2016','DD/MM/YY'),4,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('22/10/2012','DD/MM/YY'),4,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('12/08/2015','DD/MM/YY'),4,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('27/09/2012','DD/MM/YY'),4,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('08/11/2015','DD/MM/YY'),4,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('11/12/2014','DD/MM/YY'),4,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('29/07/2006','DD/MM/YY'),4,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('08/01/2008','DD/MM/YY'),4,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('28/01/2016','DD/MM/YY'),4,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('07/06/2007','DD/MM/YY'),4,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('07/08/2012','DD/MM/YY'),4,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('24/01/2007','DD/MM/YY'),5,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('04/02/2014','DD/MM/YY'),5,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('08/12/2016','DD/MM/YY'),5,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('26/04/2008','DD/MM/YY'),5,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('08/09/2016','DD/MM/YY'),5,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('20/11/2009','DD/MM/YY'),5,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('18/01/2014','DD/MM/YY'),5,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('19/03/2012','DD/MM/YY'),5,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('03/12/2015','DD/MM/YY'),5,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('02/01/2012','DD/MM/YY'),5,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('18/02/2017','DD/MM/YY'),5,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('28/03/2009','DD/MM/YY'),5,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('17/02/2017','DD/MM/YY'),5,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('07/09/2010','DD/MM/YY'),5,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('21/06/2008','DD/MM/YY'),5,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('04/05/2006','DD/MM/YY'),5,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('19/08/2015','DD/MM/YY'),5,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('26/10/2011','DD/MM/YY'),5,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('18/08/2016','DD/MM/YY'),5,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('04/12/2015','DD/MM/YY'),5,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('29/11/2015','DD/MM/YY'),5,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('13/02/2011','DD/MM/YY'),5,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('05/11/2010','DD/MM/YY'),6,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('14/04/2016','DD/MM/YY'),6,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('08/12/2010','DD/MM/YY'),6,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('02/03/2017','DD/MM/YY'),6,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('27/05/2006','DD/MM/YY'),6,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('04/10/2012','DD/MM/YY'),6,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('04/04/2011','DD/MM/YY'),6,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('20/08/2007','DD/MM/YY'),6,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('05/04/2006','DD/MM/YY'),6,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('11/01/2006','DD/MM/YY'),6,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('26/05/2016','DD/MM/YY'),6,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('30/12/2013','DD/MM/YY'),6,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('01/10/2008','DD/MM/YY'),6,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('26/08/2014','DD/MM/YY'),6,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('08/04/2015','DD/MM/YY'),6,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('26/02/2014','DD/MM/YY'),6,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('21/08/2008','DD/MM/YY'),6,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('01/06/2012','DD/MM/YY'),6,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('13/01/2007','DD/MM/YY'),6,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('07/03/2007','DD/MM/YY'),6,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('11/07/2015','DD/MM/YY'),6,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('27/09/2007','DD/MM/YY'),6,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('23/02/2014','DD/MM/YY'),7,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('16/01/2006','DD/MM/YY'),7,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('04/05/2011','DD/MM/YY'),7,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('24/01/2013','DD/MM/YY'),7,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('02/12/2011','DD/MM/YY'),7,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('28/01/2009','DD/MM/YY'),7,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('09/07/2016','DD/MM/YY'),7,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('04/02/2016','DD/MM/YY'),7,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('13/01/2009','DD/MM/YY'),7,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('18/03/2006','DD/MM/YY'),7,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('28/12/2008','DD/MM/YY'),7,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('06/01/2008','DD/MM/YY'),7,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('30/09/2007','DD/MM/YY'),7,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('16/06/2011','DD/MM/YY'),7,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('16/02/2017','DD/MM/YY'),7,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('02/08/2009','DD/MM/YY'),7,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('24/07/2016','DD/MM/YY'),7,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('22/03/2011','DD/MM/YY'),7,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('13/09/2009','DD/MM/YY'),7,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('06/03/2015','DD/MM/YY'),7,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('20/11/2010','DD/MM/YY'),7,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('19/01/2013','DD/MM/YY'),7,64);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('09/07/2007','DD/MM/YY'),8,1);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('04/07/2007','DD/MM/YY'),8,4);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('13/09/2007','DD/MM/YY'),8,7);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('23/03/2016','DD/MM/YY'),8,10);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('03/05/2014','DD/MM/YY'),8,13);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('18/09/2014','DD/MM/YY'),8,16);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('14/03/2010','DD/MM/YY'),8,19);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('12/02/2016','DD/MM/YY'),8,22);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('18/02/2016','DD/MM/YY'),8,25);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('30/11/2006','DD/MM/YY'),8,28);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('06/02/2012','DD/MM/YY'),8,31);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,5,TO_DATE('24/11/2008','DD/MM/YY'),8,34);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('09/03/2013','DD/MM/YY'),8,37);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('08/03/2014','DD/MM/YY'),8,40);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('13/11/2007','DD/MM/YY'),8,43);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('07/01/2011','DD/MM/YY'),8,46);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('01/12/2015','DD/MM/YY'),8,49);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('07/12/2013','DD/MM/YY'),8,52);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,4,TO_DATE('26/03/2014','DD/MM/YY'),8,55);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,3,TO_DATE('28/01/2011','DD/MM/YY'),8,58);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,2,TO_DATE('07/12/2013','DD/MM/YY'),8,61);
INSERT INTO prodane_leky VALUES(seq_prodane_leky.nextval,1,TO_DATE('08/03/2010','DD/MM/YY'),8,64);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY doplatky_pojistoven
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO doplatky_pojistoven VALUES(101,6,1);
INSERT INTO doplatky_pojistoven VALUES(141,7,1);
INSERT INTO doplatky_pojistoven VALUES(636,9,1);
INSERT INTO doplatky_pojistoven VALUES(1077,18,1);
INSERT INTO doplatky_pojistoven VALUES(198,19,1);
INSERT INTO doplatky_pojistoven VALUES(598,20,1);
INSERT INTO doplatky_pojistoven VALUES(90,25,1);
INSERT INTO doplatky_pojistoven VALUES(383,27,1);
INSERT INTO doplatky_pojistoven VALUES(44,28,1);
INSERT INTO doplatky_pojistoven VALUES(208,29,1);
INSERT INTO doplatky_pojistoven VALUES(109,30,1);
INSERT INTO doplatky_pojistoven VALUES(118,37,1);
INSERT INTO doplatky_pojistoven VALUES(51,38,1);
INSERT INTO doplatky_pojistoven VALUES(31,39,1);
INSERT INTO doplatky_pojistoven VALUES(53,40,1);
INSERT INTO doplatky_pojistoven VALUES(743,41,1);
INSERT INTO doplatky_pojistoven VALUES(621,42,1);
INSERT INTO doplatky_pojistoven VALUES(583,43,1);
INSERT INTO doplatky_pojistoven VALUES(519,47,1);
INSERT INTO doplatky_pojistoven VALUES(677,48,1);
INSERT INTO doplatky_pojistoven VALUES(95,49,1);
INSERT INTO doplatky_pojistoven VALUES(309,50,1);
INSERT INTO doplatky_pojistoven VALUES(82,51,1);
INSERT INTO doplatky_pojistoven VALUES(96,52,1);
INSERT INTO doplatky_pojistoven VALUES(99,53,1);
INSERT INTO doplatky_pojistoven VALUES(763,54,1);
INSERT INTO doplatky_pojistoven VALUES(19,58,1);
INSERT INTO doplatky_pojistoven VALUES(615,59,1);
INSERT INTO doplatky_pojistoven VALUES(229,60,1);
INSERT INTO doplatky_pojistoven VALUES(31,61,1);
INSERT INTO doplatky_pojistoven VALUES(146,62,1);
INSERT INTO doplatky_pojistoven VALUES(385,66,1);
INSERT INTO doplatky_pojistoven VALUES(53,67,1);
INSERT INTO doplatky_pojistoven VALUES(791,1,2);
INSERT INTO doplatky_pojistoven VALUES(172,2,2);
INSERT INTO doplatky_pojistoven VALUES(367,3,2);
INSERT INTO doplatky_pojistoven VALUES(380,4,2);
INSERT INTO doplatky_pojistoven VALUES(722,8,2);
INSERT INTO doplatky_pojistoven VALUES(428,12,2);
INSERT INTO doplatky_pojistoven VALUES(25,13,2);
INSERT INTO doplatky_pojistoven VALUES(614,14,2);
INSERT INTO doplatky_pojistoven VALUES(40,15,2);
INSERT INTO doplatky_pojistoven VALUES(221,19,2);
INSERT INTO doplatky_pojistoven VALUES(448,20,2);
INSERT INTO doplatky_pojistoven VALUES(472,24,2);
INSERT INTO doplatky_pojistoven VALUES(542,41,2);
INSERT INTO doplatky_pojistoven VALUES(864,48,2);
INSERT INTO doplatky_pojistoven VALUES(16,52,2);
INSERT INTO doplatky_pojistoven VALUES(26,53,2);
INSERT INTO doplatky_pojistoven VALUES(349,54,2);
INSERT INTO doplatky_pojistoven VALUES(49,58,2);
INSERT INTO doplatky_pojistoven VALUES(852,59,2);
INSERT INTO doplatky_pojistoven VALUES(192,60,2);
INSERT INTO doplatky_pojistoven VALUES(927,64,2);
INSERT INTO doplatky_pojistoven VALUES(194,65,2);
INSERT INTO doplatky_pojistoven VALUES(665,66,2);
INSERT INTO doplatky_pojistoven VALUES(700,67,2);
INSERT INTO doplatky_pojistoven VALUES(459,12,3);
INSERT INTO doplatky_pojistoven VALUES(177,16,3);
INSERT INTO doplatky_pojistoven VALUES(1078,17,3);
INSERT INTO doplatky_pojistoven VALUES(1070,22,3);
INSERT INTO doplatky_pojistoven VALUES(735,31,3);
INSERT INTO doplatky_pojistoven VALUES(612,32,3);
INSERT INTO doplatky_pojistoven VALUES(274,33,3);
INSERT INTO doplatky_pojistoven VALUES(402,34,3);
INSERT INTO doplatky_pojistoven VALUES(25,38,3);
INSERT INTO doplatky_pojistoven VALUES(492,39,3);
INSERT INTO doplatky_pojistoven VALUES(1347,43,3);
INSERT INTO doplatky_pojistoven VALUES(825,44,3);
INSERT INTO doplatky_pojistoven VALUES(1006,51,3);
INSERT INTO doplatky_pojistoven VALUES(169,52,3);
INSERT INTO doplatky_pojistoven VALUES(158,53,3);
INSERT INTO doplatky_pojistoven VALUES(227,54,3);
INSERT INTO doplatky_pojistoven VALUES(149,58,3);
INSERT INTO doplatky_pojistoven VALUES(399,59,3);
INSERT INTO doplatky_pojistoven VALUES(613,63,3);
INSERT INTO doplatky_pojistoven VALUES(453,64,3);
INSERT INTO doplatky_pojistoven VALUES(249,1,4);
INSERT INTO doplatky_pojistoven VALUES(81,2,4);
INSERT INTO doplatky_pojistoven VALUES(58,3,4);
INSERT INTO doplatky_pojistoven VALUES(167,4,4);
INSERT INTO doplatky_pojistoven VALUES(114,5,4);
INSERT INTO doplatky_pojistoven VALUES(292,9,4);
INSERT INTO doplatky_pojistoven VALUES(362,10,4);
INSERT INTO doplatky_pojistoven VALUES(480,14,4);
INSERT INTO doplatky_pojistoven VALUES(991,18,4);
INSERT INTO doplatky_pojistoven VALUES(69,22,4);
INSERT INTO doplatky_pojistoven VALUES(578,23,4);
INSERT INTO doplatky_pojistoven VALUES(577,24,4);
INSERT INTO doplatky_pojistoven VALUES(39,25,4);
INSERT INTO doplatky_pojistoven VALUES(201,26,4);
INSERT INTO doplatky_pojistoven VALUES(229,27,4);
INSERT INTO doplatky_pojistoven VALUES(259,28,4);
INSERT INTO doplatky_pojistoven VALUES(188,37,4);
INSERT INTO doplatky_pojistoven VALUES(53,38,4);
INSERT INTO doplatky_pojistoven VALUES(52,45,4);
INSERT INTO doplatky_pojistoven VALUES(866,46,4);
INSERT INTO doplatky_pojistoven VALUES(707,50,4);
INSERT INTO doplatky_pojistoven VALUES(81,54,4);
INSERT INTO doplatky_pojistoven VALUES(11,55,4);
INSERT INTO doplatky_pojistoven VALUES(113,56,4);
INSERT INTO doplatky_pojistoven VALUES(243,57,4);
INSERT INTO doplatky_pojistoven VALUES(99,61,4);
INSERT INTO doplatky_pojistoven VALUES(136,62,4);
INSERT INTO doplatky_pojistoven VALUES(483,66,4);
INSERT INTO doplatky_pojistoven VALUES(603,67,4);
INSERT INTO doplatky_pojistoven VALUES(271,1,5);
INSERT INTO doplatky_pojistoven VALUES(158,2,5);
INSERT INTO doplatky_pojistoven VALUES(29,3,5);
INSERT INTO doplatky_pojistoven VALUES(13,4,5);
INSERT INTO doplatky_pojistoven VALUES(42,5,5);
INSERT INTO doplatky_pojistoven VALUES(71,6,5);
INSERT INTO doplatky_pojistoven VALUES(660,10,5);
INSERT INTO doplatky_pojistoven VALUES(453,11,5);
INSERT INTO doplatky_pojistoven VALUES(636,12,5);
INSERT INTO doplatky_pojistoven VALUES(350,13,5);
INSERT INTO doplatky_pojistoven VALUES(774,14,5);
INSERT INTO doplatky_pojistoven VALUES(694,15,5);
INSERT INTO doplatky_pojistoven VALUES(410,19,5);
INSERT INTO doplatky_pojistoven VALUES(1156,20,5);
INSERT INTO doplatky_pojistoven VALUES(795,21,5);
INSERT INTO doplatky_pojistoven VALUES(11,25,5);
INSERT INTO doplatky_pojistoven VALUES(34,26,5);
INSERT INTO doplatky_pojistoven VALUES(220,27,5);
INSERT INTO doplatky_pojistoven VALUES(1412,31,5);
INSERT INTO doplatky_pojistoven VALUES(6,32,5);
INSERT INTO doplatky_pojistoven VALUES(29,33,5);
INSERT INTO doplatky_pojistoven VALUES(552,34,5);
INSERT INTO doplatky_pojistoven VALUES(746,35,5);
INSERT INTO doplatky_pojistoven VALUES(607,36,5);
INSERT INTO doplatky_pojistoven VALUES(881,37,5);
INSERT INTO doplatky_pojistoven VALUES(975,51,5);
INSERT INTO doplatky_pojistoven VALUES(808,58,5);
INSERT INTO doplatky_pojistoven VALUES(668,59,5);
INSERT INTO doplatky_pojistoven VALUES(26,60,5);
INSERT INTO doplatky_pojistoven VALUES(1008,64,5);
INSERT INTO doplatky_pojistoven VALUES(116,65,5);
INSERT INTO doplatky_pojistoven VALUES(112,66,5);
INSERT INTO doplatky_pojistoven VALUES(461,67,5);
INSERT INTO doplatky_pojistoven VALUES(867,1,6);
INSERT INTO doplatky_pojistoven VALUES(63,2,6);
INSERT INTO doplatky_pojistoven VALUES(501,9,6);
INSERT INTO doplatky_pojistoven VALUES(80,10,6);
INSERT INTO doplatky_pojistoven VALUES(213,14,6);
INSERT INTO doplatky_pojistoven VALUES(1001,15,6);
INSERT INTO doplatky_pojistoven VALUES(202,19,6);
INSERT INTO doplatky_pojistoven VALUES(1305,20,6);
INSERT INTO doplatky_pojistoven VALUES(392,27,6);
INSERT INTO doplatky_pojistoven VALUES(371,28,6);
INSERT INTO doplatky_pojistoven VALUES(153,29,6);
INSERT INTO doplatky_pojistoven VALUES(166,33,6);
INSERT INTO doplatky_pojistoven VALUES(396,37,6);
INSERT INTO doplatky_pojistoven VALUES(543,47,6);
INSERT INTO doplatky_pojistoven VALUES(852,48,6);
INSERT INTO doplatky_pojistoven VALUES(908,49,6);

--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
-- NAPLNENI TABULKY ceny_dodavatelu
--------------------------------------------------------------
--------------------------------------------------------------
--------------------------------------------------------------
INSERT INTO ceny_dodavatelu VALUES(813,1,2);
INSERT INTO ceny_dodavatelu VALUES(339,2,2);
INSERT INTO ceny_dodavatelu VALUES(725,3,2);
INSERT INTO ceny_dodavatelu VALUES(348,4,2);
INSERT INTO ceny_dodavatelu VALUES(357,5,2);
INSERT INTO ceny_dodavatelu VALUES(99,6,2);
INSERT INTO ceny_dodavatelu VALUES(408,7,2);
INSERT INTO ceny_dodavatelu VALUES(677,8,2);
INSERT INTO ceny_dodavatelu VALUES(783,9,2);
INSERT INTO ceny_dodavatelu VALUES(603,10,2);
INSERT INTO ceny_dodavatelu VALUES(1062,11,2);
INSERT INTO ceny_dodavatelu VALUES(783,12,3);
INSERT INTO ceny_dodavatelu VALUES(270,13,3);
INSERT INTO ceny_dodavatelu VALUES(667,14,3);
INSERT INTO ceny_dodavatelu VALUES(766,15,3);
INSERT INTO ceny_dodavatelu VALUES(741,16,3);
INSERT INTO ceny_dodavatelu VALUES(870,17,3);
INSERT INTO ceny_dodavatelu VALUES(1077,18,3);
INSERT INTO ceny_dodavatelu VALUES(354,19,3);
INSERT INTO ceny_dodavatelu VALUES(1020,20,3);
INSERT INTO ceny_dodavatelu VALUES(1011,21,3);
INSERT INTO ceny_dodavatelu VALUES(873,22,9);
INSERT INTO ceny_dodavatelu VALUES(963,23,9);
INSERT INTO ceny_dodavatelu VALUES(610,24,9);
INSERT INTO ceny_dodavatelu VALUES(96,25,9);
INSERT INTO ceny_dodavatelu VALUES(153,26,9);
INSERT INTO ceny_dodavatelu VALUES(718,27,9);
INSERT INTO ceny_dodavatelu VALUES(335,28,9);
INSERT INTO ceny_dodavatelu VALUES(823,29,9);
INSERT INTO ceny_dodavatelu VALUES(456,30,9);
INSERT INTO ceny_dodavatelu VALUES(1103,31,9);
INSERT INTO ceny_dodavatelu VALUES(510,32,9);
INSERT INTO ceny_dodavatelu VALUES(736,33,10);
INSERT INTO ceny_dodavatelu VALUES(702,34,10);
INSERT INTO ceny_dodavatelu VALUES(799,35,10);
INSERT INTO ceny_dodavatelu VALUES(1035,36,10);
INSERT INTO ceny_dodavatelu VALUES(742,37,10);
INSERT INTO ceny_dodavatelu VALUES(82,38,10);
INSERT INTO ceny_dodavatelu VALUES(586,39,10);
INSERT INTO ceny_dodavatelu VALUES(399,40,10);
INSERT INTO ceny_dodavatelu VALUES(626,41,10);
INSERT INTO ceny_dodavatelu VALUES(523,42,13);
INSERT INTO ceny_dodavatelu VALUES(1122,43,13);
INSERT INTO ceny_dodavatelu VALUES(837,44,13);
INSERT INTO ceny_dodavatelu VALUES(65,45,13);
INSERT INTO ceny_dodavatelu VALUES(764,46,13);
INSERT INTO ceny_dodavatelu VALUES(453,47,13);
INSERT INTO ceny_dodavatelu VALUES(876,48,13);
INSERT INTO ceny_dodavatelu VALUES(717,49,13);
INSERT INTO ceny_dodavatelu VALUES(747,50,13);
INSERT INTO ceny_dodavatelu VALUES(770,51,13);
INSERT INTO ceny_dodavatelu VALUES(603,52,13);
INSERT INTO ceny_dodavatelu VALUES(495,53,13);
INSERT INTO ceny_dodavatelu VALUES(609,54,13);
INSERT INTO ceny_dodavatelu VALUES(89,55,14);
INSERT INTO ceny_dodavatelu VALUES(533,56,14);
INSERT INTO ceny_dodavatelu VALUES(702,57,14);
INSERT INTO ceny_dodavatelu VALUES(748,58,14);
INSERT INTO ceny_dodavatelu VALUES(809,59,14);
INSERT INTO ceny_dodavatelu VALUES(400,60,14);
INSERT INTO ceny_dodavatelu VALUES(78,61,14);
INSERT INTO ceny_dodavatelu VALUES(786,62,14);
INSERT INTO ceny_dodavatelu VALUES(852,63,14);
INSERT INTO ceny_dodavatelu VALUES(756,64,14);
INSERT INTO ceny_dodavatelu VALUES(364,65,14);
INSERT INTO ceny_dodavatelu VALUES(525,66,14);
INSERT INTO ceny_dodavatelu VALUES(665,67,14);



--============================================================================
-- Ukazka optimalizacie pomocou indexu - nepodarilo sa nam zoptimalizovat
--============================================================================
-- Vyznam dotazu vo vnutri EXPLAIN:
-- Aky pocet liekov maju zarezervovanych jednotlivi zakaznici?
--============================================================================
--DROP INDEX indexExplain;
EXPLAIN PLAN FOR
SELECT rezervace.jmeno_zakaznika, COUNT(id_leku)
FROM rezervace
NATURAL JOIN rezervace_leky
GROUP BY rezervace.JMENO_ZAKAZNIKA
ORDER BY rezervace.JMENO_ZAKAZNIKA;
SELECT * FROM TABLE(DBMS_XPLAN.display);

CREATE INDEX indexExplain ON rezervace (jmeno_zakaznika);

EXPLAIN PLAN FOR
SELECT /*+ INDEX(rezervace indexExplain)*/ jmeno_zakaznika , COUNT(id_leku)
FROM rezervace
NATURAL JOIN rezervace_leky
GROUP BY rezervace.JMENO_ZAKAZNIKA
ORDER BY rezervace.JMENO_ZAKAZNIKA;
SELECT * FROM TABLE(DBMS_XPLAN.display);





--============================================================================
-- Vytvoreni materializovaneho pohledu
--============================================================================
CREATE MATERIALIZED VIEW rezervaceView
REFRESH ON COMMIT
AS SELECT jmeno_zakaznika,datum_vytvoreni,nazev
FROM xschau00.rezervace,xschau00.leky,xschau00.rezervace_leky
WHERE rezervace_leky.id_leku = leky.id_leku AND rezervace.id_rezervace = rezervace_leky.id_rezervace;

SELECT * FROM rezervaceView;
--TODO pridat insert co zmeni bazove tabulky
INSERT INTO xschau00.rezervace_leky VALUES(1,42);
COMMIT;

SELECT * FROM rezervaceView;


--spustenie procedur
exec lieky_na_predpis('02/02/2007','Afrodite');
exec lieky_na_predpis('29/05/2006','Afrodite');
exec dodavatel('Addaven');



-- --============================================================================
-- --Dva dotazy vyuzivajici spojeni dvou tabulek
-- --============================================================================
-- -- --------------------------------
-- -- Ake lieky a kolko sa predalo
-- -- na vsetkych pobockach v dna 29.5.2006?
-- -- --------------------------------
 SELECT DISTINCT nazev, SUM(prodane_leky.mnozstvi)
 FROM prodane_leky
 INNER JOIN leky ON prodane_leky.id_leku = leky.id_leku
 WHERE prodane_leky.datum = TO_DATE('29/05/2006','DD/MM/YY')
 GROUP BY leky.nazev
 ORDER BY nazev;

-- -- --------------------------------
-- -- Ake mnozstvo jednotlivych liekov
-- -- je v ramci celej siete pobociek na sklade?
-- -- --------------------------------
 SELECT nazev, SUM(leky_na_pobockach.mnozstvi) AS mnozstvi
 FROM leky_na_pobockach
 INNER JOIN leky ON leky_na_pobockach.id_leku = leky.id_leku
 GROUP BY nazev
 ORDER BY nazev;


-- --============================================================================
-- -- Dotazy vyuzivajici spojeni tri tabulek
-- --============================================================================
-- -- --------------------------------
-- -- Vypis rezervacii
-- -- --------------------------------
 SELECT jmeno_zakaznika,datum_vytvoreni,nazev
 FROM rezervace,leky,rezervace_leky
 WHERE rezervace_leky.id_leku = leky.id_leku AND rezervace.id_rezervace = rezervace_leky.id_rezervace;

-- -- --------------------------------
-- -- Vypis predpisov
-- -- --------------------------------
  SELECT rodne_cislo, nazev
  FROM predpisy
  INNER JOIN predpisy_leky ON predpisy_leky.id_predpisu = predpisy.id_predpisu
  INNER JOIN leky ON predpisy_leky.id_leku=leky.id_leku;


-- -- --------------------------------
-- -- Mnozstvo predanych jednotlivych liekov
-- -- na jednotlivych pobockach dna 29.5.2006
-- -- --------------------------------
 SELECT leky.nazev, prodane_leky.mnozstvi, pobocky.nazev_pobocky
 FROM prodane_leky, pobocky, leky
 WHERE prodane_leky.id_leku = leky.id_leku AND prodane_leky.id_pobocky = pobocky.id_pobocky AND prodane_leky.datum = TO_DATE('29/05/2006','DD/MM/YY');




-- --============================================================================
-- -- Dva dotazy s klauzuli GROUP BY a agregacni funkci:
-- --============================================================================
-- -- --------------------------------
-- -- Pocet kusov liekov na jednotlivych pobockach
-- -- --------------------------------
 SELECT nazev_pobocky, SUM(mnozstvi)
 FROM leky,leky_na_pobockach,pobocky
 WHERE leky_na_pobockach.id_leku = leky.id_leku AND leky_na_pobockach.id_pobocky = pobocky.id_pobocky
 GROUP BY pobocky.nazev_pobocky;

-- -- --------------------------------
-- -- Kolko liekov bolo vydanych jednotlivym zakaznikom na predpis
-- -- --------------------------------
  SELECT rodne_cislo,COUNT(rodne_cislo) AS pocet
  FROM predpisy
  INNER JOIN predpisy_leky on predpisy.id_predpisu = predpisy_leky.id_predpisu
  INNER JOIN leky on leky.id_leku = predpisy_leky.id_leku
  GROUP BY predpisy.rodne_cislo;




-- --============================================================================
-- -- Dotaz obsahujici predikat EXISTS:
-- --============================================================================
-- ----------------------------------------
-- -- Ake lieky sa nachadzaju len na pobocke
-- -- s nazvom "Afrodite" a nikde inde?
-- ----------------------------------------
 SELECT nazev
 FROM leky,leky_na_pobockach,pobocky
 WHERE leky.id_leku=leky_na_pobockach.id_leku AND leky_na_pobockach.id_pobocky=pobocky.id_pobocky 
  AND pobocky.nazev_pobocky='Afrodite' AND
  NOT EXISTS (SELECT *
              FROM pobocky,leky_na_pobockach
              WHERE leky.id_leku=leky_na_pobockach.id_leku AND leky_na_pobockach.id_pobocky=pobocky.id_pobocky AND pobocky.nazev_pobocky <> 'Afrodite');

  

-- --============================================================================
-- -- Dotaz s predikatem IN s vnorenym selectem:
-- --============================================================================
-- -- --------------------------------
-- -- Ktori zakaznici spravili rezervaciu na liek s cenou > 500?
-- -- --------------------------------
SELECT DISTINCT jmeno_zakaznika AS jmeno --MIN(jmeno_zakaznika) AS jmeno
FROM rezervace
INNER JOIN rezervace_leky ON (rezervace.id_rezervace=rezervace_leky.id_rezervace)
WHERE id_leku IN (SELECT id_leku FROM leky WHERE cena > 500);

COMMIT;
