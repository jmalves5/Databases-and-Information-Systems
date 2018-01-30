--Function that returns TRUE if any Region B intersects with any Region A 

DROP FUNCTION IF EXISTS region_overlaps_element;
DELIMITER $$
CREATE FUNCTION region_overlaps_element 
(series_id int, e_index int, x1b int, y1b int, x2b int, y2b int)
RETURNS boolean
BEGIN
   DECLARE x1a integer;
   DECLARE y1a integer; 
   DECLARE x2a integer; 
   DECLARE y2a integer;
   IF NOT EXISTS(
   SELECT Region.x1, Region.y1, Region.x2, Region.y2 as x1a, y1a, x2a, y2a
   FROM Region 
   WHERE (Region.series_id=series_id AND Region.elem_index=e_index 
      AND ((x1a<x1b AND x1a<x2b AND x2a<x1b AND x2a<x2b) 
      OR (x1a>x1b AND x1a>x2b AND x2a>x1b AND x2a>x2b) 
      OR (y1a<y1b AND y1a<y2b AND y2a<y1b AND y2a<y2b) 
      OR (y1a>y1b AND y1a>y2b AND y2a>y1b AND y2a>y2b))))
   THEN
      RETURN TRUE;
   ELSE 
      RETURN FALSE;
   END IF;
END $$
DELIMITER ;
