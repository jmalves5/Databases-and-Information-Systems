SELECT 
	Patient.name
FROM 
	Patient, 
	Wears, 
	Sensor, 
	Reading
WHERE 
	Patient.number=Wears.patient 
AND 
	Wears.snum=Sensor.snum 
AND 
	Wears.manuf=Sensor.manuf 
AND 
	Sensor.snum=Reading.snum 
AND 
	Sensor.manuf=Reading.manuf 
AND 
	Sensor.units='LDL cholesterol in mg/dL'
AND 
	Wears.start<=Reading.datetime 
AND 
	Wears.end>=Reading.datetime 
AND 
	Reading.value>200
AND 
	DateDiff(current_date,cast(Reading.datetime AS date)) <= 90
GROUP BY 
	Patient.name
HAVING 
	COUNT(*) >= all(SELECT COUNT(*) FROM Patient, Reading, Wears, Sensor 
WHERE 
	Patient.number = Wears.patient 
AND 
	Wears.snum = Sensor.snum
AND 
	Wears.manuf=Sensor.manuf
AND 
	Sensor.snum=Reading.snum 
AND 
	Sensor.manuf=Reading.manuf
AND 
	Sensor.units = 'LDL cholesterol in mg/dL'
AND 
	Wears.start<Reading.datetime
AND 
	Wears.end>Reading.datetime 
AND 
	Reading.value>200
AND 
	DateDiff(current_date(), cast(Reading.datetime AS date)) <= 90
GROUP BY 
	Patient.name
	);