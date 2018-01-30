DROP TABLE IF EXISTS Region, Element, Series, Study, Request, Wears, Period, Reading, Sensor, Device, Doctor, Patient;

--Table creation

create table Patient(
   number         integer NOT NULL,
   name           varchar(255) NOT NULL,
   birthday       date NOT NULL,
   address        varchar(255) NOT NULL,
   primary key(number)
);

create table Doctor(
   number         integer NOT NULL,
   doctor_id      integer NOT NULL,
   primary key(doctor_id),
   foreign key(number) references Patient(number)
);

create table Device(
   serialnum      integer NOT NULL,
   manufacturer   varchar(255) NOT NULL,
   model          varchar(255) NOT NULL,
   primary key(serialnum, manufacturer)
);

create table Sensor(
   snum          integer NOT NULL,
   manuf         varchar(255) NOT NULL,
   units         varchar(255) NOT NULL,
   primary key(snum, manuf),
   foreign key(snum, manuf) references Device(serialnum, manufacturer)
);

create table Reading(
   snum          integer NOT NULL,
   manuf         varchar(255) NOT NULL,
   datetime      timestamp NOT NULL,
   value         numeric(15,1) NOT NULL,
   primary key(snum, manuf, datetime),
   foreign key(snum, manuf) references Sensor(snum, manuf)
);

create table Period(
   start          timestamp NOT NULL,
   end            timestamp NOT NULL,
   primary key(start, end)
);

create table Wears(
   start         timestamp NOT NULL,
   end           timestamp NOT NULL,
   patient       integer NOT NULL,
   snum          integer NOT NULL,
   manuf         varchar(255) NOT NULL,
   primary key(start, end, patient),
   foreign key(start, end) references Period(start, end),
   foreign key(patient) references Patient(number),
   foreign key(snum, manuf) references Device(serialnum, manufacturer)
);

create table Request(
   number          integer NOT NULL,
   patient_id      integer NOT NULL,
   doctor_id       integer NOT NULL,
   date            timestamp NOT NULL,
   primary key(number),
   foreign key(patient_id) references Patient(number),
   foreign key(doctor_id) references Doctor(doctor_id)
);

create table Study (
   request_number   integer NOT NULL,
   description      varchar(255) NOT NULL,
   date             timestamp NOT NULL,
   doctor_id        integer NOT NULL,
   manufacturer     varchar(255) NOT NULL,
   serial_number    integer NOT NULL,
   primary key(request_number, description),
   foreign key(request_number) references Request(number),
   foreign key(doctor_id) references Doctor(doctor_id),
   foreign key(serial_number, manufacturer ) references Device(serialnum, manufacturer)
);

create table Series(
   series_id        integer NOT NULL,
   name            varchar(255) NOT NULL,
   base_url         varchar(255) NOT NULL,
   request_number   integer NOT NULL,
   description      varchar(255) NOT NULL,
   primary key(series_id),
   foreign key(request_number, description) references Study(request_number, description)   
);

create table Element(
   series_id        integer NOT NULL,
   elem_index       integer NOT NULL,
   primary key(series_id, elem_index),
   foreign key(series_id) references Series(series_id)   
);

create table Region(
   series_id        integer NOT NULL,
   elem_index       integer NOT NULL,
   x1               numeric(2,2) NOT NULL,
   y1               numeric(2,2) NOT NULL,
   x2               numeric(2,2) NOT NULL,
   y2               numeric(2,2) NOT NULL,
   primary key(series_id, elem_index, x1, y1, x2, y2),
   foreign key(series_id, elem_index) references Element(series_id, elem_index)
);