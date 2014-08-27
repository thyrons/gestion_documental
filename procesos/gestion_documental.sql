
CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
SET search_path = public, pg_catalog;
SET client_encoding=LATIN1;
CREATE FUNCTION fn_log_audit() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF (TG_TABLE_NAME = 'bitacora') THEN
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'D', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo), NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'U', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo) ,(NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo) , now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'I', NULL, (NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo), now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  else  
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'D', OLD, NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'U', OLD, NEW, now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit ("nombre_tabla", "operacion", "valor_anterior", "valor_nuevo", "fecha_cambio", "usuario")
             VALUES (TG_TABLE_NAME, 'I', NULL, NEW, now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  
  end if;
END;
$$;
LANGUAGE 'plpgsql' VOLATILE COST 100;
ALTER FUNCTION public.fn_log_audit() OWNER TO postgres;
--
-- Estrutura de la tabla 'accesos'
--

DROP TABLE accesos CASCADE;
CREATE TABLE accesos (
id_acceso int4 NOT NULL,
id_usuario int4,
id_aplicacion int4,
estado text
);

--
-- Creating data for 'accesos'
--

INSERT INTO accesos VALUES ('10','2','1','p');
INSERT INTO accesos VALUES ('11','2','2','p');
INSERT INTO accesos VALUES ('12','2','3','p');
INSERT INTO accesos VALUES ('13','2','4','a');
INSERT INTO accesos VALUES ('14','2','5','a');
INSERT INTO accesos VALUES ('15','2','6','a');
INSERT INTO accesos VALUES ('16','2','7','p');
INSERT INTO accesos VALUES ('17','2','8','p');
INSERT INTO accesos VALUES ('18','2','9','p');
INSERT INTO accesos VALUES ('1','1','1','a');
INSERT INTO accesos VALUES ('2','1','2','a');
INSERT INTO accesos VALUES ('3','1','3','a');
INSERT INTO accesos VALUES ('4','1','4','a');
INSERT INTO accesos VALUES ('5','1','5','a');
INSERT INTO accesos VALUES ('6','1','6','a');
INSERT INTO accesos VALUES ('7','1','7','a');
INSERT INTO accesos VALUES ('8','1','8','a');
INSERT INTO accesos VALUES ('9','1','9','a');


--
-- Creating index for 'accesos'
--

ALTER TABLE ONLY  accesos  ADD CONSTRAINT  accesos_pkey  PRIMARY KEY  (id_acceso);

--
-- Estrutura de la tabla 'aplicaciones'
--

DROP TABLE aplicaciones CASCADE;
CREATE TABLE aplicaciones (
id_aplicacion int4 NOT NULL,
nombre_aplicacion text,
direccion text
);

--
-- Creating data for 'aplicaciones'
--

INSERT INTO aplicaciones VALUES ('1','Ubicaciones','ubicaciones.php');
INSERT INTO aplicaciones VALUES ('2','Ingresos Varios','varios.php');
INSERT INTO aplicaciones VALUES ('3','Nuevos Usuarios','usuarios.php');
INSERT INTO aplicaciones VALUES ('4','Reportes','reportes.php');
INSERT INTO aplicaciones VALUES ('5','Buscar Documentos','buscarTexto.php');
INSERT INTO aplicaciones VALUES ('6','Datos Usuario','datos_personales.php');
INSERT INTO aplicaciones VALUES ('7','Respaldo','../procesos/backup.php');
INSERT INTO aplicaciones VALUES ('8','Restuarar Archivos','restaurar_archivo.php');
INSERT INTO aplicaciones VALUES ('9','Graficos Estadisticos','graficos.php');


--
-- Creating index for 'aplicaciones'
--

ALTER TABLE ONLY  aplicaciones  ADD CONSTRAINT  aplicaciones_pkey  PRIMARY KEY  (id_aplicacion);

--
-- Estrutura de la tabla 'archivo'
--

DROP TABLE archivo CASCADE;
CREATE TABLE archivo (
id_archivo int4 NOT NULL,
nombre_archivo text,
codigo_archivo text,
id_tipo_doc int4,
id_creador int4,
estado text
);

--
-- Creating data for 'archivo'
--

INSERT INTO archivo VALUES ('1','23423','S-2014-07-14-txt-1-1','2','1','0');


--
-- Creating index for 'archivo'
--

ALTER TABLE ONLY  archivo  ADD CONSTRAINT  archivo_pkey  PRIMARY KEY  (id_archivo);

--
-- Estrutura de la tabla 'auditoria_sistema'
--

DROP TABLE auditoria_sistema CASCADE;
CREATE TABLE auditoria_sistema (
id_sistema int4 NOT NULL,
usuario text,
fecha_cambio text,
tabla text,
operacion text,
anterior text,
nuevo text,
observacion text
);

--
-- Creating data for 'auditoria_sistema'
--

INSERT INTO auditoria_sistema VALUES ('1','willy 1','2014-06-07','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-06,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-07,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('2','willy 1','2014-06-07',NULL,'Backup',NULL,NULL,'Respaldo de la base de datos por el usuario Willy Narvaez');
INSERT INTO auditoria_sistema VALUES ('3','willy 1','2014-06-09','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-07,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('4','willy 1','2014-06-09 09:44:28','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('5','willy 1','2014-06-09 09:44:28','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('6','willy 1','2014-06-09 09:44:28','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('7','willy 1','2014-06-09 09:44:28','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('8','willy 1','2014-06-09 09:44:28','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('9','willy 1','2014-06-09 09:44:28','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('10','willy 1','2014-06-09 09:51:31','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('11','willy 1','2014-06-09 09:51:31','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('12','willy 1','2014-06-09 09:51:31','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('13','willy 1','2014-06-09 09:51:31','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('14','willy 1','2014-06-09 09:51:31','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('15','willy 1','2014-06-09 09:51:31','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('16','willy 1','2014-06-09 09:52:10','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('17','willy 1','2014-06-09 09:52:10','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('18','willy 1','2014-06-09 09:52:10','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('19','willy 1','2014-06-09 09:52:10','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('20','willy 1','2014-06-09 09:52:10','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('21','willy 1','2014-06-09 09:52:10','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('22','willy 1','2014-06-09 09:55:05','archivo','Insert',NULL,'1,wqe,b-2014-06-09-sql-1-1,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('23','willy 1','2014-06-09 09:55:05','bitacora','Insert',NULL,'1,wqe,2014-06-09 09:55:05,,Administrador,Willy Narvaez,',,22997,base201406090955051.sql,application/sql','Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('24','willy 1','2014-06-09 09:55:05','metas','Insert',NULL,'1,nombre,base201406090955051.sql,wqe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('25','willy 1','2014-06-09 09:55:05','metas','Insert',NULL,'2,tipo,application/sql,wqe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('26','willy 1','2014-06-09 09:55:05','metas','Insert',NULL,'3,peso,22997,wqe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('27','willy 1','2014-06-09 09:55:05','recibidos','Insert',NULL,'1,wqe,Willy Narvaez,Enviado','Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('28','willy 1','2014-06-09 09:55:23','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('29','willy 1','2014-06-09 09:55:23','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('30','willy 1','2014-06-09 09:55:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('31','willy 1','2014-06-09 09:55:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('32','willy 1','2014-06-09 09:55:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('33','willy 1','2014-06-09 09:55:23','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('34','willy 1','2014-06-09','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('35','willy 1','2014-06-09','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('36','willy 1','2014-06-09 10:08:33','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('37','willy 1','2014-06-09 10:08:33','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('38','willy 1','2014-06-09 10:08:33','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('39','willy 1','2014-06-09 10:08:33','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('40','willy 1','2014-06-09 10:08:33','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('41','willy 1','2014-06-09 10:08:33','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('42','willy 1','2014-06-09 10:13:23','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('43','willy 1','2014-06-09 10:13:23','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('44','willy 1','2014-06-09 10:13:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('45','willy 1','2014-06-09 10:13:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('46','willy 1','2014-06-09 10:13:23','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('47','willy 1','2014-06-09 10:13:23','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('48','willy 1','2014-06-09 10:14:02','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('49','willy 1','2014-06-09 10:14:02','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('50','willy 1','2014-06-09 10:14:02','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('51','willy 1','2014-06-09 10:14:02','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('52','willy 1','2014-06-09 10:14:02','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('53','willy 1','2014-06-09 10:14:02','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('54',' 2','2014-06-09','usuario','Update',NULL,NULL,'Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('55','willy 1','2014-06-09','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('56','willy 1','2014-06-09 10:25:54','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('57','willy 1','2014-06-09 10:25:54','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('58','willy 1','2014-06-09 10:25:54','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('59','willy 1','2014-06-09 10:25:54','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('60','willy 1','2014-06-09 10:25:54','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('61','willy 1','2014-06-09 10:25:54','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('62','willy 1','2014-06-09 10:26:29','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('63','willy 1','2014-06-09 10:26:29','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('64','willy 1','2014-06-09 10:26:29','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('65','willy 1','2014-06-09 10:26:29','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('66','willy 1','2014-06-09 10:26:29','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('67','willy 1','2014-06-09 10:26:29','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('68','willy 1','2014-06-09 10:38:32','archivo','Insert',NULL,'2,qwe,H-2014-06-09-pdf-2-2,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('69','willy 1','2014-06-09 10:40:01','archivo','Insert',NULL,'3,QWE,H-2014-06-09-pdf-3-2,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('70','willy 1','2014-06-09 10:44:42','archivo','Insert',NULL,'4,WER,H-2014-06-09-pdf-4-2,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('71','willy 1','2014-06-09','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('72','willy 1','2014-06-09 10:52:40','archivo','Insert',NULL,'5,qwe,H-2014-06-09-pdf-5-2,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('73','willy 1','2014-06-09 10:53:41','archivo','Insert',NULL,'6,qwe,H-2014-06-09-pdf-6-2,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('74','willy 1','2014-06-09 10:53:41','bitacora','Insert',NULL,'2,qwe,2014-06-09 10:53:41,,Administrador,Willy Narvaez,',,43293854,HTML5 Y CSS3201406091053416.pdf,application/pdf','Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('75','willy 1','2014-06-09 10:53:41','metas','Insert',NULL,'4,nombre,HTML5 Y CSS3201406091053416.pdf,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('76','willy 1','2014-06-09 10:53:41','metas','Insert',NULL,'5,tipo,application/pdf,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('77','willy 1','2014-06-09 10:53:41','metas','Insert',NULL,'6,peso,43293854,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('78','willy 1','2014-06-09 10:53:41','recibidos','Insert',NULL,'2,qwe,Willy Narvaez,Enviado','Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('79','willy 1','2014-06-09 10:57:29','archivo','Insert',NULL,'7,qwe,C-2014-06-09-rar-7-3,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('80','willy 1','2014-06-09 10:59:38','archivo','Insert',NULL,NULL,'Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('81','willy 1','2014-06-09 10:59:38','bitacora','Insert',NULL,NULL,'Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('82','willy 1','2014-06-09 10:59:38','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('83','willy 1','2014-06-09 10:59:38','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('84','willy 1','2014-06-09 10:59:38','metas','Insert',NULL,NULL,'Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('85','willy 1','2014-06-09 10:59:38','recibidos','Insert',NULL,NULL,'Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('86','willy 1','2014-06-09 11:19:58','archivo','Insert',NULL,'8,qwe,C-2014-06-09-rar-8-3,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('87','willy 1','2014-06-09 11:19:58','bitacora','Insert',NULL,'3,qwe,2014-06-09 11:19:58,,Administrador,Willy Narvaez,',,243845945,Curso Php avanzado201406091119588.rar,application/x-rar','Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('88','willy 1','2014-06-09 11:19:58','metas','Insert',NULL,'7,nombre,Curso Php avanzado201406091119588.rar,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('89','willy 1','2014-06-09 11:19:58','metas','Insert',NULL,'8,tipo,application/x-rar,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('90','willy 1','2014-06-09 11:19:58','metas','Insert',NULL,'9,peso,243845945,qwe','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('91','willy 1','2014-06-09 11:19:58','recibidos','Insert',NULL,'3,qwe,Willy Narvaez,Enviado','Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('92','willy 1','2014-06-09',NULL,'Descarga de archivos',NULL,NULL,'Descarga del documento por el usuario Willy Narvaez');
INSERT INTO auditoria_sistema VALUES ('93','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-09,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('94','willy 1','2014-06-11','tipo_usuario','Insert',NULL,'2,DOCENTE','Nuevo tipo de usuario');
INSERT INTO auditoria_sistema VALUES ('95','willy 1','2014-06-11','usuario','Insert',NULL,'2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,,Uniandes,Administrador,Administrador','Creacion de un nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('96','willy 1','2014-06-11','clave','Insert',NULL,'2,MTIz,lUIS pERES','Creacion de una nueva clave para el usuario');
INSERT INTO auditoria_sistema VALUES ('97','willy 1','2014-06-11','accesos','Insert',NULL,'10,lUIS pERES,Ubicaciones,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('98','willy 1','2014-06-11','accesos','Insert',NULL,'11,lUIS pERES,Ingresos Varios,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('99','willy 1','2014-06-11','accesos','Insert',NULL,'12,lUIS pERES,Nuevos Usuarios,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('100','willy 1','2014-06-11','accesos','Insert',NULL,'13,lUIS pERES,Reportes,a','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('101','willy 1','2014-06-11','accesos','Insert',NULL,'14,lUIS pERES,Buscar Documentos,a','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('102','willy 1','2014-06-11','accesos','Insert',NULL,'15,lUIS pERES,Datos Usuario,a','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('103','willy 1','2014-06-11','accesos','Insert',NULL,'16,lUIS pERES,Respaldo,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('104','willy 1','2014-06-11','accesos','Insert',NULL,'17,lUIS pERES,Restuarar Archivos,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('105','willy 1','2014-06-11','accesos','Insert',NULL,'18,lUIS pERES,Graficos Estadisticos,p','Creacion de accesos para el nuevo usuario');
INSERT INTO auditoria_sistema VALUES ('106','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('107','luis 2','2014-06-11','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('108','luis 2','2014-06-11','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('109','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('110','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('111','luis 2','2014-06-11','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('112','luis 2','2014-06-11','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('113','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('114','willy 1','2014-06-11','accesos','Update','1,Willy Narvaez,Ubicaciones,a','1,Willy Narvaez,Ubicaciones,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('115','willy 1','2014-06-11','accesos','Update','2,Willy Narvaez,Ingresos Varios,a','2,Willy Narvaez,Ingresos Varios,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('116','willy 1','2014-06-11','accesos','Update','3,Willy Narvaez,Nuevos Usuarios,a','3,Willy Narvaez,Nuevos Usuarios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('117','willy 1','2014-06-11','accesos','Update','4,Willy Narvaez,Reportes,a','4,Willy Narvaez,Reportes,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('118','willy 1','2014-06-11','accesos','Update','5,Willy Narvaez,Buscar Documentos,a','5,Willy Narvaez,Buscar Documentos,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('119','willy 1','2014-06-11','accesos','Update','6,Willy Narvaez,Datos Usuario,a','6,Willy Narvaez,Datos Usuario,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('120','willy 1','2014-06-11','accesos','Update','7,Willy Narvaez,Respaldo,a','7,Willy Narvaez,Respaldo,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('121','willy 1','2014-06-11','accesos','Update','8,Willy Narvaez,Restuarar Archivos,a','8,Willy Narvaez,Restuarar Archivos,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('122','willy 1','2014-06-11','accesos','Update','9,Willy Narvaez,Graficos Estadisticos,a','9,Willy Narvaez,Graficos Estadisticos,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('123','willy 1','2014-06-11','accesos','Update','1,Willy Narvaez,Ubicaciones,p','1,Willy Narvaez,Ubicaciones,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('124','willy 1','2014-06-11','accesos','Update','2,Willy Narvaez,Ingresos Varios,p','2,Willy Narvaez,Ingresos Varios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('125','willy 1','2014-06-11','accesos','Update','3,Willy Narvaez,Nuevos Usuarios,a','3,Willy Narvaez,Nuevos Usuarios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('126','willy 1','2014-06-11','accesos','Update','4,Willy Narvaez,Reportes,p','4,Willy Narvaez,Reportes,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('127','willy 1','2014-06-11','accesos','Update','5,Willy Narvaez,Buscar Documentos,p','5,Willy Narvaez,Buscar Documentos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('128','willy 1','2014-06-11','accesos','Update','6,Willy Narvaez,Datos Usuario,p','6,Willy Narvaez,Datos Usuario,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('129','willy 1','2014-06-11','accesos','Update','7,Willy Narvaez,Respaldo,p','7,Willy Narvaez,Respaldo,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('130','willy 1','2014-06-11','accesos','Update','8,Willy Narvaez,Restuarar Archivos,p','8,Willy Narvaez,Restuarar Archivos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('131','willy 1','2014-06-11','accesos','Update','9,Willy Narvaez,Graficos Estadisticos,p','9,Willy Narvaez,Graficos Estadisticos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('132','willy 1','2014-06-11','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('133','willy 1','2014-07-14','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-06-11,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('134','willy 1','2014-07-14','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('135','willy 1','2014-07-14 17:22:05','archivo','Insert',NULL,'1,23423,S-2014-07-14-txt-1-1,(2,DOC,DOCUMENTO,Activo),Willy Narvaez,0','Creación de un archivo nuevo por el usuario');
INSERT INTO auditoria_sistema VALUES ('136','willy 1','2014-07-14 17:22:05','bitacora','Insert',NULL,'1,23423,2014-07-14 17:22:05,wer,Administrador,Willy Narvaez,',wer,344,SimpleGrammarES1201407141722051.txt,text/plain','Nueva versión del archivo original');
INSERT INTO auditoria_sistema VALUES ('137','willy 1','2014-07-14 17:22:05','metas','Insert',NULL,'1,nombre,SimpleGrammarES1201407141722051.txt,23423','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('138','willy 1','2014-07-14 17:22:05','metas','Insert',NULL,'2,tipo,text/plain,23423','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('139','willy 1','2014-07-14 17:22:05','metas','Insert',NULL,'3,peso,344,23423','Creación de una meta para el archivo creado');
INSERT INTO auditoria_sistema VALUES ('140','willy 1','2014-07-14 17:22:05','recibidos','Insert',NULL,'1,23423,Willy Narvaez,Enviado','Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('141','willy 1','2014-07-14 17:22:05','recibidos','Insert',NULL,'2,23423,lUIS pERES,Enviado','Envio del archivo subido a todos los usuarios relacionados');
INSERT INTO auditoria_sistema VALUES ('142','willy 1 ','2014-07-14','recibidos','Update','1,23423,Willy Narvaez,Enviado,1','1,23423,Willy Narvaez,Enviado,0','El documento enviado ha sido chequeado por el o los destinatarios');
INSERT INTO auditoria_sistema VALUES ('143','willy 1','2014-07-14',NULL,'Descarga de archivos',NULL,NULL,'Descarga del documento por el usuario Willy Narvaez');
INSERT INTO auditoria_sistema VALUES ('144','willy 1','2014-07-14 17:24:21','archivo','Update','1,23423,S-2014-07-14-txt-1-1,DOCUMENTO,Willy Narvaez,0','1,23423,S-2014-07-14-txt-1-1,DOCUMENTO,Willy Narvaez,0','Modificacion del archivo por el usuario');
INSERT INTO auditoria_sistema VALUES ('145','willy 1','2014-07-14 17:24:21','bitacora','Insert',NULL,'2,23423,2014-07-14 17:24:21,wer,Administrador,Willy Narvaez,',wer,233,SimpleGrammarES2201407141724211.txt,text/plain,','Nueva version del archivo subido por el usuario');
INSERT INTO auditoria_sistema VALUES ('146','willy 1','2014-07-14 17:24:21','recibidos','Update','2,23423,lUIS pERES,Enviado,1','2,23423,lUIS pERES,Enviado,1','Modificacion de los estados del archivos a los usuarios ');
INSERT INTO auditoria_sistema VALUES ('147','willy 1','2014-07-14 17:24:21','recibidos','Update','1,23423,Willy Narvaez,Enviado,0','1,23423,Willy Narvaez,Enviado,1','Modificacion de los estados del archivos a los usuarios ');
INSERT INTO auditoria_sistema VALUES ('148','willy 1','2014-07-14',NULL,'Descarga de archivos',NULL,NULL,'Descarga del documento por el usuario Willy Narvaez');
INSERT INTO auditoria_sistema VALUES ('149','willy 1','2014-07-14','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('150','luis 2','2014-07-14','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-06-11,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-07-14,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('151','luis 2','2014-07-14','usuario','Update','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-07-14,Uniandes,Administrador,Administrador','2,l112,lUIS pERES,Ibarra,Otavalo,,,w_nar@f.fcom,DOCENTE,luis,2014-07-14,Uniandes,Administrador,Administrador','Salida del sistema por el usuario actual');
INSERT INTO auditoria_sistema VALUES ('152','willy 1','2014-07-14','usuario','Update','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','1,Wi,Willy Narvaez,Otavalo,Otavalo,062922992,091212121,w_narvaez@hotamil.com,ADMINISTRADOR,willy,2014-07-14,Uniandes,Administrador,Administrador','Ingreso del usuario al sistema');
INSERT INTO auditoria_sistema VALUES ('153','willy 1','2014-07-14','accesos','Update','1,Willy Narvaez,Ubicaciones,a','1,Willy Narvaez,Ubicaciones,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('154','willy 1','2014-07-14','accesos','Update','2,Willy Narvaez,Ingresos Varios,a','2,Willy Narvaez,Ingresos Varios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('155','willy 1','2014-07-14','accesos','Update','3,Willy Narvaez,Nuevos Usuarios,a','3,Willy Narvaez,Nuevos Usuarios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('156','willy 1','2014-07-14','accesos','Update','4,Willy Narvaez,Reportes,a','4,Willy Narvaez,Reportes,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('157','willy 1','2014-07-14','accesos','Update','5,Willy Narvaez,Buscar Documentos,a','5,Willy Narvaez,Buscar Documentos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('158','willy 1','2014-07-14','accesos','Update','6,Willy Narvaez,Datos Usuario,a','6,Willy Narvaez,Datos Usuario,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('159','willy 1','2014-07-14','accesos','Update','7,Willy Narvaez,Respaldo,a','7,Willy Narvaez,Respaldo,p','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('160','willy 1','2014-07-14','accesos','Update','8,Willy Narvaez,Restuarar Archivos,a','8,Willy Narvaez,Restuarar Archivos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('161','willy 1','2014-07-14','accesos','Update','9,Willy Narvaez,Graficos Estadisticos,a','9,Willy Narvaez,Graficos Estadisticos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('162','willy 1','2014-07-14','accesos','Update','1,Willy Narvaez,Ubicaciones,a','1,Willy Narvaez,Ubicaciones,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('163','willy 1','2014-07-14','accesos','Update','2,Willy Narvaez,Ingresos Varios,a','2,Willy Narvaez,Ingresos Varios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('164','willy 1','2014-07-14','accesos','Update','3,Willy Narvaez,Nuevos Usuarios,a','3,Willy Narvaez,Nuevos Usuarios,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('165','willy 1','2014-07-14','accesos','Update','4,Willy Narvaez,Reportes,a','4,Willy Narvaez,Reportes,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('166','willy 1','2014-07-14','accesos','Update','5,Willy Narvaez,Buscar Documentos,a','5,Willy Narvaez,Buscar Documentos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('167','willy 1','2014-07-14','accesos','Update','6,Willy Narvaez,Datos Usuario,a','6,Willy Narvaez,Datos Usuario,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('168','willy 1','2014-07-14','accesos','Update','7,Willy Narvaez,Respaldo,p','7,Willy Narvaez,Respaldo,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('169','willy 1','2014-07-14','accesos','Update','8,Willy Narvaez,Restuarar Archivos,a','8,Willy Narvaez,Restuarar Archivos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('170','willy 1','2014-07-14','accesos','Update','9,Willy Narvaez,Graficos Estadisticos,a','9,Willy Narvaez,Graficos Estadisticos,a','Modificacion de un acceso del usuario por algun administrador');
INSERT INTO auditoria_sistema VALUES ('171','willy 1','2014-07-14',NULL,'Descarga de archivos',NULL,NULL,'Descarga del documento(bitacora) por el usuario Willy Narvaez');
INSERT INTO auditoria_sistema VALUES ('172','willy 1','2014-07-14',NULL,'Backup',NULL,NULL,'Respaldo de la base de datos por el usuario Willy Narvaez');


--
-- Creating index for 'auditoria_sistema'
--

ALTER TABLE ONLY  auditoria_sistema  ADD CONSTRAINT  auditoria_sistema_pkey  PRIMARY KEY  (id_sistema);

--
-- Estrutura de la tabla 'bitacora
--

DROP TABLE bitacora CASCADE;
CREATE TABLE bitacora (
id_bitacora int4 NOT NULL,
id_archivo int4,
fecha_cambio text,
asunto_cambio text,
id_departamento int4,
id_usuario int4,
archivo_bytea bytea,
observaciones text,
peso text,
referencia text,
tipo text
);

--
-- Creating data for 'bitacora'
--

INSERT INTO bitacora VALUES ('1','1','2014-07-14 17:22:05','wer','1','1','\x234a5347462056312e303b0d0a6772616d6d61722073656e74656e63653b0d0a0d0a7075626c6963203c73656e74656e63653e203d0d0a5b3c6461746f303e5d0d0a5b3c6461746f313e5d0d0a5b3c6461746f323e5d0d0a5b3c6461746f333e5d0d0a5b3c6461746f343e5d0d0a5b3c6461746f353e5d0d0a5b3c6461746f363e5d0d0a5b3c6461746f373e5d0d0a5b3c6461746f383e5d3b0d0a0d0a0d0a3c6461746f303e3d696d616e617368613b0d0a3c6461746f313e3d6b6179616b616d616e3b0d0a3c6461746f323e3d6a61746172696368693b0d0a3c6461746f333e3d6a6172696775616775613b0d0a3c6461746f343e3d7561726d696775616775613b0d0a3c6461746f353e3d6d696b756e61756b753b0d0a3c6461746f363e3d6a6174756e6d616d613b0d0a3c6461746f373e3d6368616e67613b0d0a3c6461746f383e3d71756972756b756e613b0d0a0d0a0d0a0d0a','wer','344','SimpleGrammarES1201407141722051.txt','text/plain');
INSERT INTO bitacora VALUES ('2','1','2014-07-14 17:24:21','wer','1','1','\x234a5347462056312e303b0d0a6772616d6d61722073656e74656e63653b0d0a0d0a7075626c6963203c73656e74656e63653e203d0d0a5b3c6461746f303e5d0d0a5b3c6461746f313e5d0d0a5b3c6461746f323e5d0d0a5b3c6461746f333e5d0d0a5b3c6461746f343e5d0d0a5b3c6461746f353e5d3b0d0a0d0a3c6461746f303e3d6e69756b616e6368693b0d0a3c6461746f313e3d73756b74613b0d0a3c6461746f323e3d6b7573696c6c613b0d0a3c6461746f333e3d616e6b61733b0d0a3c6461746f343e3d6175616b693b0d0a3c6461746f353e3d6b696c6b616e616b617370693b0d0a','wer','233','SimpleGrammarES2201407141724211.txt','text/plain');


--
-- Creating index for 'bitacora'
--

ALTER TABLE ONLY  bitacora  ADD CONSTRAINT  bitacora_pkey  PRIMARY KEY  (id_bitacora);

--
-- Estrutura de la tabla  'categorias'
--

DROP TABLE categorias CASCADE;
CREATE TABLE categorias (
id_categoria int4 NOT NULL,
nombre_categoria text,
codigo_categoria text,
estado text
);

--
-- Creating data for 'categorias'
--

INSERT INTO categorias VALUES ('1','Administrador','ADM','1');


--
-- Creating index for 'categorias'
--

ALTER TABLE ONLY  categorias  ADD CONSTRAINT  categorias_pkey  PRIMARY KEY  (id_categoria);

--
-- Estrutura de la tabla 'ciudad'
--

DROP TABLE ciudad CASCADE;
CREATE TABLE ciudad (
id_ciudad int4 NOT NULL,
nombre_ciudad text,
id_provincia int4
);

--
-- Creating data for 'ciudad'
--

INSERT INTO ciudad VALUES ('1','Otavalo','1');


--
-- Creating index for 'ciudad'
--

ALTER TABLE ONLY  ciudad  ADD CONSTRAINT  ciudad_pkey  PRIMARY KEY  (id_ciudad);

--
-- Estrutura de la tabla 'clave'
--

DROP TABLE clave CASCADE;
CREATE TABLE clave (
id_clave int4 NOT NULL,
clave text,
usuario int4
);

--
-- Creating data for 'clave'
--

INSERT INTO clave VALUES ('1','MTIz','1');
INSERT INTO clave VALUES ('2','MTIz','2');


--
-- Creating index for 'clave'
--

ALTER TABLE ONLY  clave  ADD CONSTRAINT  clave_pkey  PRIMARY KEY  (id_clave);

--
-- Estrutura de la tabla 'departamento'
--

DROP TABLE departamento CASCADE;
CREATE TABLE departamento (
id_departamento int4 NOT NULL,
codigo_departamento text,
nombre_departamento text,
estado text
);

--
-- Creating data for 'departamento'
--

INSERT INTO departamento VALUES ('1','ADM','Administrador','Activo');


--
-- Creating index for 'departamento'
--

ALTER TABLE ONLY  departamento  ADD CONSTRAINT  departamento_pkey  PRIMARY KEY  (id_departamento);

--
-- Estrutura de la tabla 'medio_recepcion'
--

DROP TABLE medio_recepcion CASCADE;
CREATE TABLE medio_recepcion (
id_medio int4 NOT NULL,
codigo_medio text,
nombre_medio text,
estado text
);

--
-- Creating data for 'medio_recepcion'
--



--
-- Creating index for 'medio_recepcion'
--

ALTER TABLE ONLY  medio_recepcion  ADD CONSTRAINT  medio_recepcion_pkey  PRIMARY KEY  (id_medio);

--
-- Estrutura de la tabla 'metas'
--

DROP TABLE metas CASCADE;
CREATE TABLE metas (
id_meta int4 NOT NULL,
nombre_meta text,
descripcion_meta text,
id_archivo int4
);

--
-- Creating data for 'metas'
--

INSERT INTO metas VALUES ('1','nombre','SimpleGrammarES1201407141722051.txt','1');
INSERT INTO metas VALUES ('2','tipo','text/plain','1');
INSERT INTO metas VALUES ('3','peso','344','1');


--
-- Creating index for 'metas'
--

ALTER TABLE ONLY  metas  ADD CONSTRAINT  metas_pkey  PRIMARY KEY  (id_meta);

--
-- Estrutura de la tabla 'pais'
--

DROP TABLE pais CASCADE;
CREATE TABLE pais (
id_pais int4 NOT NULL,
nombre_pais text
);

--
-- Creating data for 'pais'
--

INSERT INTO pais VALUES ('1','Ecuador');


--
-- Creating index for 'pais'
--

ALTER TABLE ONLY  pais  ADD CONSTRAINT  pais_pkey  PRIMARY KEY  (id_pais);

--
-- Estrutura de la tabla 'provincias'
--

DROP TABLE provincias CASCADE;
CREATE TABLE provincias (
id_provincia int4 NOT NULL,
nombre_provincia text,
id_pais int4
);

--
-- Creating data for 'provincias'
--

INSERT INTO provincias VALUES ('1','Imbabura','1');


--
-- Creating index for 'provincias'
--

ALTER TABLE ONLY  provincias  ADD CONSTRAINT  provincias_pkey  PRIMARY KEY  (id_provincia);

--
-- Estrutura de la tabla 'recibidos'
--

DROP TABLE recibidos CASCADE;
CREATE TABLE recibidos (
id_recibido int4 NOT NULL,
id_archivo int4,
id_usuarios int4,
estado text,
leido int4
);

--
-- Creating data for 'recibidos'
--

INSERT INTO recibidos VALUES ('2','1','2','Enviado','1');
INSERT INTO recibidos VALUES ('1','1','1','Enviado','1');


--
-- Creating index for 'recibidos'
--

ALTER TABLE ONLY  recibidos  ADD CONSTRAINT  recibidos_pkey  PRIMARY KEY  (id_recibido);

--
-- Estrutura de la tabla 'tipo_documento'
--

DROP TABLE tipo_documento CASCADE;
CREATE TABLE tipo_documento (
id_tipo_documento int4 NOT NULL,
codigo_doc text,
nombre_doc text,
estado_doc text
);

--
-- Creating data for 'tipo_documento'
--

INSERT INTO tipo_documento VALUES ('2','DOC','DOCUMENTO','Activo');
INSERT INTO tipo_documento VALUES ('1','CAR','CARTA','Activo');
INSERT INTO tipo_documento VALUES ('3','ARC','ARCHIVO','Activo');


--
-- Creating index for 'tipo_documento'
--

ALTER TABLE ONLY  tipo_documento  ADD CONSTRAINT  tipo_documento_pkey  PRIMARY KEY  (id_tipo_documento);

--
-- Estrutura de la tabla 'tbl_audit'
--

DROP TABLE tbl_audit CASCADE;
CREATE SEQUENCE tbl_audit_pk_audit_seq
    START WITH 1027
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
CREATE TABLE tbl_audit (
pk_audit int4 NOT NULL DEFAULT nextval('tbl_audit_pk_audit_seq'::regclass) ,
nombre_tabla text NOT NULL,
operacion character(1) NOT NULL,
valor_anterior text,
valor_nuevo text,
fecha_cambio timestamp NOT NULL,
usuario text NOT NULL
);

--
-- Creating data for 'tbl_audit'
--

INSERT INTO tbl_audit VALUES ('907','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-06,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-07,Uniandes,1,1)','2014-06-07 13:53:32.44024','postgres');
INSERT INTO tbl_audit VALUES ('908','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-07,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','2014-06-09 09:43:58.062961','postgres');
INSERT INTO tbl_audit VALUES ('909','archivo','I',NULL,'(1,wqe,b-2014-06-09-sql-1-1,2,1,0)','2014-06-09 09:55:05.359964','postgres');
INSERT INTO tbl_audit VALUES ('910','bitacora','I',NULL,'(1,1,"2014-06-09 09:55:05","",1,1,"",22997,base201406090955051.sql,application/sql)','2014-06-09 09:55:05.412492','postgres');
INSERT INTO tbl_audit VALUES ('911','metas','I',NULL,'(1,nombre,base201406090955051.sql,1)','2014-06-09 09:55:05.466787','postgres');
INSERT INTO tbl_audit VALUES ('912','metas','I',NULL,'(2,tipo,application/sql,1)','2014-06-09 09:55:05.489752','postgres');
INSERT INTO tbl_audit VALUES ('913','metas','I',NULL,'(3,peso,22997,1)','2014-06-09 09:55:05.511074','postgres');
INSERT INTO tbl_audit VALUES ('914','recibidos','I',NULL,'(1,1,1,Enviado,1)','2014-06-09 09:55:05.534076','postgres');
INSERT INTO tbl_audit VALUES ('915','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','2014-06-09 10:08:18.681756','postgres');
INSERT INTO tbl_audit VALUES ('916','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','2014-06-09 10:23:28.642648','postgres');
INSERT INTO tbl_audit VALUES ('917','archivo','I',NULL,'(2,qwe,H-2014-06-09-pdf-2-2,2,1,0)','2014-06-09 10:38:32.866093','postgres');
INSERT INTO tbl_audit VALUES ('918','archivo','I',NULL,'(3,QWE,H-2014-06-09-pdf-3-2,2,1,0)','2014-06-09 10:40:01.585089','postgres');
INSERT INTO tbl_audit VALUES ('919','archivo','I',NULL,'(4,WER,H-2014-06-09-pdf-4-2,2,1,0)','2014-06-09 10:44:43.169164','postgres');
INSERT INTO tbl_audit VALUES ('920','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','2014-06-09 10:47:34.483489','postgres');
INSERT INTO tbl_audit VALUES ('921','archivo','I',NULL,'(5,qwe,H-2014-06-09-pdf-5-2,2,1,0)','2014-06-09 10:52:40.58147','postgres');
INSERT INTO tbl_audit VALUES ('922','archivo','I',NULL,'(6,qwe,H-2014-06-09-pdf-6-2,2,1,0)','2014-06-09 10:53:42.067089','postgres');
INSERT INTO tbl_audit VALUES ('923','bitacora','I',NULL,'(2,6,"2014-06-09 10:53:41","",1,1,"",43293854,"HTML5 Y CSS3201406091053416.pdf",application/pdf)','2014-06-09 10:53:45.908345','postgres');
INSERT INTO tbl_audit VALUES ('924','metas','I',NULL,'(4,nombre,"HTML5 Y CSS3201406091053416.pdf",6)','2014-06-09 10:53:54.460771','postgres');
INSERT INTO tbl_audit VALUES ('925','metas','I',NULL,'(5,tipo,application/pdf,6)','2014-06-09 10:53:54.594416','postgres');
INSERT INTO tbl_audit VALUES ('926','metas','I',NULL,'(6,peso,43293854,6)','2014-06-09 10:53:54.704929','postgres');
INSERT INTO tbl_audit VALUES ('927','recibidos','I',NULL,'(2,6,1,Enviado,1)','2014-06-09 10:53:54.727882','postgres');
INSERT INTO tbl_audit VALUES ('928','archivo','I',NULL,'(7,qwe,C-2014-06-09-rar-7-3,2,1,0)','2014-06-09 10:57:45.722749','postgres');
INSERT INTO tbl_audit VALUES ('929','archivo','I',NULL,'(8,qwe,C-2014-06-09-rar-8-3,2,1,0)','2014-06-09 11:20:00.711822','postgres');
INSERT INTO tbl_audit VALUES ('930','bitacora','I',NULL,'(3,8,"2014-06-09 11:19:58","",1,1,"",243845945,"Curso Php avanzado201406091119588.rar",application/x-rar)','2014-06-09 11:20:29.172994','postgres');
INSERT INTO tbl_audit VALUES ('931','metas','I',NULL,'(7,nombre,"Curso Php avanzado201406091119588.rar",8)','2014-06-09 11:23:14.672268','postgres');
INSERT INTO tbl_audit VALUES ('932','metas','I',NULL,'(8,tipo,application/x-rar,8)','2014-06-09 11:23:15.230008','postgres');
INSERT INTO tbl_audit VALUES ('933','metas','I',NULL,'(9,peso,243845945,8)','2014-06-09 11:23:15.396797','postgres');
INSERT INTO tbl_audit VALUES ('934','recibidos','I',NULL,'(3,8,1,Enviado,1)','2014-06-09 11:23:16.495726','postgres');
INSERT INTO tbl_audit VALUES ('935','archivo','D','(1,wqe,b-2014-06-09-sql-1-1,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('936','archivo','D','(2,qwe,H-2014-06-09-pdf-2-2,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('937','archivo','D','(3,QWE,H-2014-06-09-pdf-3-2,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('938','archivo','D','(4,WER,H-2014-06-09-pdf-4-2,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('939','archivo','D','(5,qwe,H-2014-06-09-pdf-5-2,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('940','archivo','D','(6,qwe,H-2014-06-09-pdf-6-2,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('941','archivo','D','(7,qwe,C-2014-06-09-rar-7-3,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('942','archivo','D','(8,qwe,C-2014-06-09-rar-8-3,2,1,0)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('943','bitacora','D','(1,1,"2014-06-09 09:55:05","",1,1,"",22997,base201406090955051.sql,application/sql)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('944','recibidos','D','(1,1,1,Enviado,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('945','metas','D','(1,nombre,base201406090955051.sql,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('946','metas','D','(2,tipo,application/sql,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('947','metas','D','(3,peso,22997,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('948','bitacora','D','(2,6,"2014-06-09 10:53:41","",1,1,"",43293854,"HTML5 Y CSS3201406091053416.pdf",application/pdf)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('949','recibidos','D','(2,6,1,Enviado,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('950','metas','D','(4,nombre,"HTML5 Y CSS3201406091053416.pdf",6)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('951','metas','D','(5,tipo,application/pdf,6)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('952','metas','D','(6,peso,43293854,6)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('953','bitacora','D','(3,8,"2014-06-09 11:19:58","",1,1,"",243845945,"Curso Php avanzado201406091119588.rar",application/x-rar)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('954','recibidos','D','(3,8,1,Enviado,1)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('955','metas','D','(7,nombre,"Curso Php avanzado201406091119588.rar",8)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('956','metas','D','(8,tipo,application/x-rar,8)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('957','metas','D','(9,peso,243845945,8)',NULL,'2014-06-09 12:07:51.022134','postgres');
INSERT INTO tbl_audit VALUES ('958','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-09,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','2014-06-11 12:09:06.366727','postgres');
INSERT INTO tbl_audit VALUES ('959','tipo_usuario','I',NULL,'(2,DOCENTE)','2014-06-11 12:10:08.334165','postgres');
INSERT INTO tbl_audit VALUES ('960','usuario','I',NULL,'(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,"",Uniandes,1,1)','2014-06-11 12:10:38.265276','postgres');
INSERT INTO tbl_audit VALUES ('961','clave','I',NULL,'(2,MTIz,2)','2014-06-11 12:10:38.289594','postgres');
INSERT INTO tbl_audit VALUES ('962','accesos','I',NULL,'(10,2,1,p)','2014-06-11 12:10:38.355066','postgres');
INSERT INTO tbl_audit VALUES ('963','accesos','I',NULL,'(11,2,2,p)','2014-06-11 12:10:38.378991','postgres');
INSERT INTO tbl_audit VALUES ('964','accesos','I',NULL,'(12,2,3,p)','2014-06-11 12:10:38.401008','postgres');
INSERT INTO tbl_audit VALUES ('965','accesos','I',NULL,'(13,2,4,a)','2014-06-11 12:10:38.423198','postgres');
INSERT INTO tbl_audit VALUES ('966','accesos','I',NULL,'(14,2,5,a)','2014-06-11 12:10:38.445594','postgres');
INSERT INTO tbl_audit VALUES ('967','accesos','I',NULL,'(15,2,6,a)','2014-06-11 12:10:38.468104','postgres');
INSERT INTO tbl_audit VALUES ('968','accesos','I',NULL,'(16,2,7,p)','2014-06-11 12:10:38.489852','postgres');
INSERT INTO tbl_audit VALUES ('969','accesos','I',NULL,'(17,2,8,p)','2014-06-11 12:10:38.512002','postgres');
INSERT INTO tbl_audit VALUES ('970','accesos','I',NULL,'(18,2,9,p)','2014-06-11 12:10:38.545591','postgres');
INSERT INTO tbl_audit VALUES ('971','usuario','U','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,"",Uniandes,1,1)','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,2014-06-11,Uniandes,1,1)','2014-06-11 12:10:49.067889','postgres');
INSERT INTO tbl_audit VALUES ('972','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','2014-06-11 12:40:59.965689','postgres');
INSERT INTO tbl_audit VALUES ('973','usuario','U','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,2014-06-11,Uniandes,1,1)','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,2014-06-11,Uniandes,1,1)','2014-06-11 12:48:30.97983','postgres');
INSERT INTO tbl_audit VALUES ('974','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','2014-06-11 12:52:57.125612','postgres');
INSERT INTO tbl_audit VALUES ('975','accesos','U','(1,1,1,a)','(1,1,1,p)','2014-06-11 12:58:52.927459','postgres');
INSERT INTO tbl_audit VALUES ('976','accesos','U','(2,1,2,a)','(2,1,2,p)','2014-06-11 12:58:52.95027','postgres');
INSERT INTO tbl_audit VALUES ('977','accesos','U','(3,1,3,a)','(3,1,3,a)','2014-06-11 12:58:52.972117','postgres');
INSERT INTO tbl_audit VALUES ('978','accesos','U','(4,1,4,a)','(4,1,4,p)','2014-06-11 12:58:52.994429','postgres');
INSERT INTO tbl_audit VALUES ('979','accesos','U','(5,1,5,a)','(5,1,5,p)','2014-06-11 12:58:53.016717','postgres');
INSERT INTO tbl_audit VALUES ('980','accesos','U','(6,1,6,a)','(6,1,6,p)','2014-06-11 12:58:53.038832','postgres');
INSERT INTO tbl_audit VALUES ('981','accesos','U','(7,1,7,a)','(7,1,7,p)','2014-06-11 12:58:53.061145','postgres');
INSERT INTO tbl_audit VALUES ('982','accesos','U','(8,1,8,a)','(8,1,8,p)','2014-06-11 12:58:53.083224','postgres');
INSERT INTO tbl_audit VALUES ('983','accesos','U','(9,1,9,a)','(9,1,9,p)','2014-06-11 12:58:53.105445','postgres');
INSERT INTO tbl_audit VALUES ('984','accesos','U','(1,1,1,p)','(1,1,1,a)','2014-06-11 12:59:10.505683','postgres');
INSERT INTO tbl_audit VALUES ('985','accesos','U','(2,1,2,p)','(2,1,2,a)','2014-06-11 12:59:10.528083','postgres');
INSERT INTO tbl_audit VALUES ('986','accesos','U','(3,1,3,a)','(3,1,3,a)','2014-06-11 12:59:10.55004','postgres');
INSERT INTO tbl_audit VALUES ('987','accesos','U','(4,1,4,p)','(4,1,4,a)','2014-06-11 12:59:10.572153','postgres');
INSERT INTO tbl_audit VALUES ('988','accesos','U','(5,1,5,p)','(5,1,5,a)','2014-06-11 12:59:10.594609','postgres');
INSERT INTO tbl_audit VALUES ('989','accesos','U','(6,1,6,p)','(6,1,6,a)','2014-06-11 12:59:10.616893','postgres');
INSERT INTO tbl_audit VALUES ('990','accesos','U','(7,1,7,p)','(7,1,7,a)','2014-06-11 12:59:10.63913','postgres');
INSERT INTO tbl_audit VALUES ('991','accesos','U','(8,1,8,p)','(8,1,8,a)','2014-06-11 12:59:10.662391','postgres');
INSERT INTO tbl_audit VALUES ('992','accesos','U','(9,1,9,p)','(9,1,9,a)','2014-06-11 12:59:10.683801','postgres');
INSERT INTO tbl_audit VALUES ('993','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-06-11,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-07-14,Uniandes,1,1)','2014-07-14 17:19:16.911186','postgres');
INSERT INTO tbl_audit VALUES ('994','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-07-14,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-07-14,Uniandes,1,1)','2014-07-14 17:20:47.334132','postgres');
INSERT INTO tbl_audit VALUES ('995','archivo','I',NULL,'(1,23423,S-2014-07-14-txt-1-1,2,1,0)','2014-07-14 17:22:05.640592','postgres');
INSERT INTO tbl_audit VALUES ('996','bitacora','I',NULL,'(1,1,"2014-07-14 17:22:05",wer,1,1,wer,344,SimpleGrammarES1201407141722051.txt,text/plain)','2014-07-14 17:22:05.689958','postgres');
INSERT INTO tbl_audit VALUES ('997','metas','I',NULL,'(1,nombre,SimpleGrammarES1201407141722051.txt,1)','2014-07-14 17:22:05.734828','postgres');
INSERT INTO tbl_audit VALUES ('998','metas','I',NULL,'(2,tipo,text/plain,1)','2014-07-14 17:22:05.779335','postgres');
INSERT INTO tbl_audit VALUES ('999','metas','I',NULL,'(3,peso,344,1)','2014-07-14 17:22:05.801587','postgres');
INSERT INTO tbl_audit VALUES ('1000','recibidos','I',NULL,'(1,1,1,Enviado,1)','2014-07-14 17:22:05.825814','postgres');
INSERT INTO tbl_audit VALUES ('1001','recibidos','I',NULL,'(2,1,2,Enviado,1)','2014-07-14 17:22:05.845893','postgres');
INSERT INTO tbl_audit VALUES ('1002','recibidos','U','(1,1,1,Enviado,1)','(1,1,1,Enviado,0)','2014-07-14 17:22:23.834972','postgres');
INSERT INTO tbl_audit VALUES ('1003','archivo','U','(1,23423,S-2014-07-14-txt-1-1,2,1,0)','(1,23423,S-2014-07-14-txt-1-1,2,1,0)','2014-07-14 17:24:21.384096','postgres');
INSERT INTO tbl_audit VALUES ('1004','bitacora','I',NULL,'(2,1,"2014-07-14 17:24:21",wer,1,1,wer,233,SimpleGrammarES2201407141724211.txt,text/plain)','2014-07-14 17:24:21.414905','postgres');
INSERT INTO tbl_audit VALUES ('1005','recibidos','U','(2,1,2,Enviado,1)','(2,1,2,Enviado,1)','2014-07-14 17:24:21.438066','postgres');
INSERT INTO tbl_audit VALUES ('1006','recibidos','U','(1,1,1,Enviado,0)','(1,1,1,Enviado,1)','2014-07-14 17:24:21.459004','postgres');
INSERT INTO tbl_audit VALUES ('1007','usuario','U','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,2014-06-11,Uniandes,1,1)','(2,l112,"lUIS pERES",Ibarra,1,"","",w_nar@f.fcom,2,luis,2014-07-14,Uniandes,1,1)','2014-07-14 17:25:30.403154','postgres');
INSERT INTO tbl_audit VALUES ('1008','usuario','U','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-07-14,Uniandes,1,1)','(1,Wi,"Willy Narvaez",Otavalo,1,062922992,091212121,w_narvaez@hotamil.com,1,willy,2014-07-14,Uniandes,1,1)','2014-07-14 17:25:53.458946','postgres');
INSERT INTO tbl_audit VALUES ('1009','accesos','U','(1,1,1,a)','(1,1,1,a)','2014-07-14 17:26:42.625544','postgres');
INSERT INTO tbl_audit VALUES ('1010','accesos','U','(2,1,2,a)','(2,1,2,a)','2014-07-14 17:26:42.647758','postgres');
INSERT INTO tbl_audit VALUES ('1011','accesos','U','(3,1,3,a)','(3,1,3,a)','2014-07-14 17:26:42.669981','postgres');
INSERT INTO tbl_audit VALUES ('1012','accesos','U','(4,1,4,a)','(4,1,4,a)','2014-07-14 17:26:42.692291','postgres');
INSERT INTO tbl_audit VALUES ('1013','accesos','U','(5,1,5,a)','(5,1,5,a)','2014-07-14 17:26:42.714673','postgres');
INSERT INTO tbl_audit VALUES ('1014','accesos','U','(6,1,6,a)','(6,1,6,a)','2014-07-14 17:26:42.736681','postgres');
INSERT INTO tbl_audit VALUES ('1015','accesos','U','(7,1,7,a)','(7,1,7,p)','2014-07-14 17:26:42.758916','postgres');
INSERT INTO tbl_audit VALUES ('1016','accesos','U','(8,1,8,a)','(8,1,8,a)','2014-07-14 17:26:42.781264','postgres');
INSERT INTO tbl_audit VALUES ('1017','accesos','U','(9,1,9,a)','(9,1,9,a)','2014-07-14 17:26:43.003535','postgres');
INSERT INTO tbl_audit VALUES ('1018','accesos','U','(1,1,1,a)','(1,1,1,a)','2014-07-14 17:26:53.292413','postgres');
INSERT INTO tbl_audit VALUES ('1019','accesos','U','(2,1,2,a)','(2,1,2,a)','2014-07-14 17:26:53.314818','postgres');
INSERT INTO tbl_audit VALUES ('1020','accesos','U','(3,1,3,a)','(3,1,3,a)','2014-07-14 17:26:53.336956','postgres');
INSERT INTO tbl_audit VALUES ('1021','accesos','U','(4,1,4,a)','(4,1,4,a)','2014-07-14 17:26:53.359309','postgres');
INSERT INTO tbl_audit VALUES ('1022','accesos','U','(5,1,5,a)','(5,1,5,a)','2014-07-14 17:26:53.381387','postgres');
INSERT INTO tbl_audit VALUES ('1023','accesos','U','(6,1,6,a)','(6,1,6,a)','2014-07-14 17:26:53.403661','postgres');
INSERT INTO tbl_audit VALUES ('1024','accesos','U','(7,1,7,p)','(7,1,7,a)','2014-07-14 17:26:53.425818','postgres');
INSERT INTO tbl_audit VALUES ('1025','accesos','U','(8,1,8,a)','(8,1,8,a)','2014-07-14 17:26:53.447988','postgres');
INSERT INTO tbl_audit VALUES ('1026','accesos','U','(9,1,9,a)','(9,1,9,a)','2014-07-14 17:26:53.470178','postgres');


--
-- Creating index for 'tbl_audit'
--

ALTER TABLE ONLY  tbl_audit  ADD CONSTRAINT  pk_audit  PRIMARY KEY  (pk_audit);

--
-- Estrutura de la tabla 'tipo_documento'
--

DROP TABLE tipo_documento CASCADE;
CREATE TABLE tipo_documento (
id_tipo_documento int4 NOT NULL,
codigo_doc text,
nombre_doc text,
estado_doc text
);

--
-- Creating data for 'tipo_documento'
--

INSERT INTO tipo_documento VALUES ('2','DOC','DOCUMENTO','Activo');
INSERT INTO tipo_documento VALUES ('1','CAR','CARTA','Activo');
INSERT INTO tipo_documento VALUES ('3','ARC','ARCHIVO','Activo');


--
-- Creating index for 'tipo_documento'
--

ALTER TABLE ONLY  tipo_documento  ADD CONSTRAINT  tipo_documento_pkey  PRIMARY KEY  (id_tipo_documento);

--
-- Estrutura de la tabla 'tipo_usuario'
--

DROP TABLE tipo_usuario CASCADE;
CREATE TABLE tipo_usuario (
id_tipo_usuario int4 NOT NULL,
nombre_tipo text
);

--
-- Creating data for 'tipo_usuario'
--

INSERT INTO tipo_usuario VALUES ('1','ADMINISTRADOR');
INSERT INTO tipo_usuario VALUES ('2','DOCENTE');


--
-- Creating index for 'tipo_usuario'
--

ALTER TABLE ONLY  tipo_usuario  ADD CONSTRAINT  tipo_usuario_pkey  PRIMARY KEY  (id_tipo_usuario);

--
-- Estrutura de la tabla 'usuario'
--

DROP TABLE usuario CASCADE;
CREATE TABLE usuario (
id_usuario int4 NOT NULL,
cod_usuario text,
nombres_usuario text,
direccion_usuario text,
id_ciudad int4,
telefono_usuario text,
celular_usuario text,
email_usuario text,
id_tipo_user int4,
nick_usuario text,
fecha text,
institucion text,
id_categoria int4,
id_departamento int4
);

--
-- Creating data for 'usuario'
--

INSERT INTO usuario VALUES ('2','l112','lUIS pERES','Ibarra','1',NULL,NULL,'w_nar@f.fcom','2','luis','2014-07-14','Uniandes','1','1');
INSERT INTO usuario VALUES ('1','Wi','Willy Narvaez','Otavalo','1','062922992','091212121','w_narvaez@hotamil.com','1','willy','2014-07-14','Uniandes','1','1');


--
-- Creating index for 'usuario'
--

ALTER TABLE ONLY  usuario  ADD CONSTRAINT  usuario_pkey  PRIMARY KEY  (id_usuario);


--
-- Creating relacionships for 'accesos'
--

ALTER TABLE ONLY accesos ADD CONSTRAINT r_usuario_acceso FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'archivo'
--

ALTER TABLE ONLY archivo ADD CONSTRAINT r_tipo_doc_archivo FOREIGN KEY (id_tipo_doc) REFERENCES tipo_documento(id_tipo_documento) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'bitacora'
--

ALTER TABLE ONLY bitacora ADD CONSTRAINT r_departamento_bitacora FOREIGN KEY (id_departamento) REFERENCES departamento(id_departamento) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'bitacora'
--

ALTER TABLE ONLY bitacora ADD CONSTRAINT r_usuario_bitacora FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'bitacora'
--

ALTER TABLE ONLY bitacora ADD CONSTRAINT r_archivo_bitacora FOREIGN KEY (id_archivo) REFERENCES archivo(id_archivo) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'ciudad'
--

ALTER TABLE ONLY ciudad ADD CONSTRAINT r_provincia_ciudad FOREIGN KEY (id_provincia) REFERENCES provincias(id_provincia) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'metas'
--

ALTER TABLE ONLY metas ADD CONSTRAINT r_meta_archivo FOREIGN KEY (id_archivo) REFERENCES archivo(id_archivo) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'provincias'
--

ALTER TABLE ONLY provincias ADD CONSTRAINT r_provincia_pais FOREIGN KEY (id_pais) REFERENCES pais(id_pais) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'recibidos'
--

ALTER TABLE ONLY recibidos ADD CONSTRAINT r_archivo_recibido FOREIGN KEY (id_archivo) REFERENCES archivo(id_archivo) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'usuario'
--

ALTER TABLE ONLY usuario ADD CONSTRAINT r_categoria_usuario FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'usuario'
--

ALTER TABLE ONLY usuario ADD CONSTRAINT r_usuario_ciudad FOREIGN KEY (id_ciudad) REFERENCES ciudad(id_ciudad) ON UPDATE CASCADE ON DELETE CASCADE;

--
-- Creating relacionships for 'usuario'
--

ALTER TABLE ONLY usuario ADD CONSTRAINT r_usuario_tipo_usuario FOREIGN KEY (id_tipo_user) REFERENCES tipo_usuario(id_tipo_usuario) ON UPDATE CASCADE ON DELETE CASCADE;
CREATE TRIGGER tbl_accesos_tg_audit AFTER INSERT OR DELETE OR UPDATE ON accesos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_aplicaciones_tg_audit AFTER INSERT OR DELETE OR UPDATE ON aplicaciones FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_archivo_tg_audit AFTER INSERT OR DELETE OR UPDATE ON archivo FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_bitacora_tg_audit AFTER INSERT OR DELETE OR UPDATE ON bitacora FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_categorias_tg_audit AFTER INSERT OR DELETE OR UPDATE ON categorias FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_ciudad_tg_audit AFTER INSERT OR DELETE OR UPDATE ON ciudad FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_clave_tg_audit AFTER INSERT OR DELETE OR UPDATE ON clave FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_departamento_tg_audit AFTER INSERT OR DELETE OR UPDATE ON departamento FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_medio_recepcion_tg_audit AFTER INSERT OR DELETE OR UPDATE ON medio_recepcion FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_metas_tg_audit AFTER INSERT OR DELETE OR UPDATE ON metas FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_pais_tg_audit AFTER INSERT OR DELETE OR UPDATE ON pais FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_provincias_tg_audit AFTER INSERT OR DELETE OR UPDATE ON provincias FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_recibidos_tg_audit AFTER INSERT OR DELETE OR UPDATE ON recibidos FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_tipo_documento_tg_audit AFTER INSERT OR DELETE OR UPDATE ON tipo_documento FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_tipo_usuario_tg_audit AFTER INSERT OR DELETE OR UPDATE ON tipo_usuario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();
CREATE TRIGGER tbl_usuario_tg_audit AFTER INSERT OR DELETE OR UPDATE ON usuario FOR EACH ROW EXECUTE PROCEDURE fn_log_audit();