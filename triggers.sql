--Triggers 

--Triggers that blocks invalid Period entries (not requested)
--Insert


DROP TRIGGER IF EXISTS insertPeriod;
DELIMITER $$
CREATE TRIGGER insertPeriod 
BEFORE INSERT ON Period
FOR EACH ROW
BEGIN
	IF (new.start>new.end)
   THEN
      SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "INSERT Period start can't be after Period end";
   END IF;
END$$
DELIMITER ;


--Update (not requested)

DROP TRIGGER IF EXISTS updatePeriod;
DELIMITER $$
CREATE TRIGGER updatePeriod 
BEFORE UPDATE ON Period
FOR EACH ROW
BEGIN
	IF (new.start>new.end)
   THEN
      SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "UPDATE Period start can't be after Period end";
   END IF;
END$$
DELIMITER ;


--Trigger if the doctor that prescribed the exam is set to conduct the exam thorugh an Insert in the Study table (requested). 

--The trigger doesn't allow this to happen and block the insert.

DROP TRIGGER IF EXISTS insertDiffDoctor;
DELIMITER $$
CREATE TRIGGER insertDiffDoctor 
BEFORE INSERT ON Study
FOR EACH ROW
BEGIN
	IF (
		new.doctor_id=(SELECT Request.doctor_id FROM Request WHERE Request.number = new.request_number))
	THEN 
		SIGNAL SQLSTATE '45000' 
		SET MESSAGE_TEXT = "Sorry! Can't insert. The doctor that requests an exam cannot conduct that exam.";
	END IF;
END$$
DELIMITER ;


--Trigger if the doctor that prescribed the exam is set to conduct the exam thorugh an Update in the Study table (requested). 

--The trigger doesn't allow this to happen and blocks the update.

DROP TRIGGER IF EXISTS updateDiffDoctor;
DELIMITER $$
CREATE TRIGGER updateDiffDoctor 
BEFORE UPDATE ON Study
FOR EACH ROW
BEGIN
	IF (
		new.doctor_id=(SELECT Request.doctor_id FROM Request WHERE Request.number = new.request_number))
	THEN 
		SIGNAL SQLSTATE '45000' 
		SET MESSAGE_TEXT = "Sorry! Can't update. The doctor that requests an exam cannot conduct that exam.";
	END IF;
END$$
DELIMITER ;


--Triggers if a device is to different patients during overlapping periods of time thorugh an Insert in the Wears table (requested). 

--This trigger doesn't allow this to happen and blocks the insert.

DROP TRIGGER IF EXISTS insertDevicePeriod;

DELIMITER $$
CREATE TRIGGER insertDevicePeriod 
BEFORE INSERT ON Wears
FOR EACH ROW
BEGIN
   IF EXISTS(
   	  SELECT * FROM Wears WHERE (((new.manuf=Wears.manuf) 
   	  AND (new.snum=Wears.snum) 
   	  AND ((new.end<Wears.end AND new.end>Wears.start) OR (new.start>Wears.start AND new.start<Wears.end))))) 
   THEN
      SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "Overlapping Periods";
   END IF;
END$$
DELIMITER ;


--This trigger doesn't allow this to happen and blocks the update (requested).
DROP TRIGGER IF EXISTS updateDevicePeriod;
DELIMITER $$
CREATE TRIGGER updateDevicePeriod 
BEFORE UPDATE ON Wears
FOR EACH ROW
BEGIN
   IF EXISTS(
   	  SELECT * FROM Wears WHERE (((new.manuf=Wears.manuf) 
   	  AND (new.snum=Wears.snum) 
   	  AND ((new.end<Wears.end AND new.end>Wears.start) OR (new.start>Wears.start AND new.start<Wears.end))))) 
   THEN
      SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "Overlapping Periods";
   END IF;
END$$
DELIMITER ;