INSERT INTO sinais_vitais
SELECT C1.subject_id as paciente,
 	   date_part('year',age(C1.charttime, P.dob)) as idade,
       P.gender,
       C1.charttime as horario,
       C1.value as frequencia_cardiaca,
FROM chartevents C1, patients P
WHERE C1.value is not null 
AND C1.value != '0'
AND C1.itemid = 211 
AND P.subject_id = C1.subject_id
