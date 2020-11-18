SELECT  DISTINCT       ON(C1.row_id) C1.row_id, 
               C1.subject_id as paciente,
               C1.charttime as horario_hr,
               date_part('year',age(C1.charttime, P.dob)) as idade,
               P.gender,
               C1.value as frequencia_cardiaca,
               C2.value as frequencia_respiratoria, 
               C3.value as temperature,
               C4.value as pressao_sys,
               C5.value as pressao_dias
              
                FROM chartevents C1,chartevents C2, chartevents C3, chartevents C4, chartevents C5,chartevents C6,patients P
                WHERE C1.subject_id = 3 
                AND C1.itemid = 211
                AND C2.itemid = 618 
                AND C3.itemid = 676
                AND C4.itemid = 51
                AND C5.itemid = 8368 
                AND C6.itemid = 646 
                AND (C1.charttime = C2.charttime and C3.charttime = C1.charttime and C1.charttime = C4.charttime and C5.charttime = C1.charttime) 
                LIMIT 2;