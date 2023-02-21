<?php
function get_vaccinated_status($st)
{
   $st = (int) $st;
   switch ($st) {
      case -1:
         return 'Not available';
      case 0:
         return 'Negative';
      case 1:
         return 'Positive';
   }
}
