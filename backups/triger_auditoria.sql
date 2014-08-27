CREATE OR REPLACE FUNCTION fn_log_audit()
  RETURNS trigger AS
$BODY$
BEGIN
  IF (TG_TABLE_NAME = 'bitacora') THEN
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'D', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo), NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'U', (OLD.id_bitacora,OLD.id_archivo,OLD.fecha_cambio,OLD.asunto_cambio,OLD.id_departamento,OLD.id_usuario,OLD.observaciones,OLD.peso,OLD.referencia,OLD.tipo) ,(NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo) , now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'I', NULL, (NEW.id_bitacora,NEW.id_archivo,NEW.fecha_cambio,NEW.asunto_cambio,NEW.id_departamento,NEW.id_usuario,NEW.observaciones,NEW.peso,NEW.referencia,NEW.tipo), now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  else  
    IF (TG_OP = 'DELETE') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'D', OLD, NULL, now(), USER);
      RETURN OLD;
    ELSIF (TG_OP = 'UPDATE') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'U', OLD, NEW, now(), USER);
      RETURN NEW;
    ELSIF (TG_OP = 'INSERT') THEN
      INSERT INTO tbl_audit ("TableName", "Operation", "OldValue", "NewValue", "UpdateDate", "UserName")
             VALUES (TG_TABLE_NAME, 'I', NULL, NEW, now(), USER);
      RETURN NEW;
    END IF;
    RETURN NULL;
  
  end if;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION fn_log_audit()
  OWNER TO postgres;

