package com.example.chyntia.simulasi_ig.view.utilities;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by Vinixz on 12/11/2017.
 */

public class DatetimeUtils {

    public static Date stringToDate(String tanggal) throws ParseException {
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-M-dd hh:mm:ss");
        String dateInString = tanggal;
        Date date = sdf.parse(dateInString);
        return date;
    }
}
