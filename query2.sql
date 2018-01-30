SELECT 
    Patient.name
FROM
    Patient,
    Study,
    Request
WHERE
    Patient.number = Request.patient_id
    AND 
    	Request.number = Study.request_number
    AND 
    	Study.manufacturer = 'Medtronic' 
    AND 
    	YEAR(Study.date) = YEAR(current_date - INTERVAL 1 YEAR)
    GROUP BY 
    	name
    HAVING 
    COUNT(DISTINCT Study.serial_number)=(SELECT 
    										COUNT(DISTINCT Device.serialnum)
    									FROM
                    					   	Device
                						WHERE
                    						Device.manufacturer = 'Medtronic');