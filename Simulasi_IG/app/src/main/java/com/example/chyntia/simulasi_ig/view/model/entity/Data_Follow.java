package com.example.chyntia.simulasi_ig.view.model.entity;

/**
 * Created by Chyntia on 4/12/2017.
 */

public class Data_Follow {
    public String nama,status,pp;

    private int id;
    private String user_id, follow_user_id, created_on;

    public Data_Follow(String pp, String nama, String status){
        this.nama =  nama;
        this.pp = pp;
        this.status = status;
    }

    public Data_Follow(int id, String user_id, String follow_user_id, String created_on) {
        this.id = id;
        this.user_id = user_id;
        this.follow_user_id = follow_user_id;
        this.created_on = created_on;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getFollow_user_id() {
        return follow_user_id;
    }

    public void setFollow_user_id(String follow_user_id) {
        this.follow_user_id = follow_user_id;
    }

    public String getCreated_on() {
        return created_on;
    }

    public void setCreated_on(String created_on) {
        this.created_on = created_on;
    }
}
