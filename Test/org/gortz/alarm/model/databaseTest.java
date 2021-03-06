package org.gortz.alarm.model;

import org.gortz.alarm.model.Databases.Mysql;
import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import static junit.framework.TestCase.fail;
import static org.gortz.alarm.model.Alarms.Alarm.Status.OFF;
import static org.gortz.alarm.model.Alarms.Alarm.Status.ON;


/**
 * Created by adrian on 19/04/16.
 */
public class databaseTest {
    Database db;
    @Before
    public void setUp() throws Exception {
        try {
            db = new Mysql("shss", "APJ4A5M6sXTPBH74");
        }catch (Exception e){
         fail("Could not create database connection.");
        }
    }

    @After
    public void tearDown() throws Exception {
    }

    @Test
    public void AlarmStatus() throws Exception {
        boolean oldDbStatus = false;

        //Get status atm and save it for later so we don't change the database.
        try {
            oldDbStatus = db.getAlarmStatus();
        }catch (Exception e){
            fail("Couldn't get the alarm status from database");
        }

        try {
            db.updateAlarmStatus(OFF);
            if (db.getAlarmStatus()) fail("Didn't change the db value or couldn't retrieve the right status");
            db.updateAlarmStatus(ON);
            if (!db.getAlarmStatus()) fail("Didn't change the db value or couldn't retrieve the right status");
        }catch (Exception e){
            fail("couldn't change alarm status in database");
        }

        //Set database status back to the state it had before we tested.
        try {
            if(oldDbStatus){
                db.updateAlarmStatus(ON);
            }else db.updateAlarmStatus(OFF);
        }catch (Exception e){
        }


    }


}