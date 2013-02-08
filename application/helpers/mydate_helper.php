<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Europe/Berlin');

/**
         *      senad
         *      getDateFromDateTime
         *      
         *      @params date-time(string), time, date, or nothing
         *      @returns date or time or both(date and time)
         * 
         */
        function srb_date($date_time, $show='') {
                
                $year = date('Y', strtotime($date_time));  
                $month = date('n', strtotime($date_time));
                $two_dig_month = date('m', strtotime($date_time));
                $day = date('d', strtotime($date_time));   
                //$time = date('H:i', strtotime($date_time));
                //$hour = date('H', strtotime($date_time));               
                $minute = date('i', strtotime($date_time));
                $date_time_str = strtotime($date_time);
                $hour = date('H', strtotime('+1 hour',$date_time_str));/*Prikaz vremena u najnovije*/
                                
                $months = array(    
                          'Januar', 
                          'Februar',
                          'Mart',     
                          'April',    
                          'Maj',      
                          'Jun',      
                          'Jul',      
                          'Avgust',   
                          'Septembar',
                          'Oktobar', 
                          'Novembar',
                          'Decembar'
                );
        
                $serbian_months = array_combine(range(1,12), $months);
        
                        switch($show){
        
                                case "date":
                                        $human_readable_date = $day. ". " .$serbian_months[$month]." ".$year. ". ";
                                break;
                                case "time":
                                        $human_readable_date = $time;
                                break;   
                                default :
                                        //$human_readable_date = $day. ". " .$serbian_months[$month]." ".$year. ". ".$time;
                                        //$human_readable_date = $day. ". " .$serbian_months[$month]." ".$year. ". ".$hour.":".$minute;
                                        $human_readable_date = $day. "." .$two_dig_month.".".$year. ".";
                                break;
                        }
         
         
                return $human_readable_date;
         
}