package com.jing.util;

import java.text.DateFormat;
import java.util.*;

public class TimeInfo {
    public String getTime(){
    	Date date = new Date();
    	DateFormat dateFormat = DateFormat.getDateInstance(DateFormat.FULL);
    	return dateFormat.format(date);
    }
}
