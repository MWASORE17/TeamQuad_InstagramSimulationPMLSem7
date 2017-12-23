package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.network.model.Notif;

import java.util.ArrayList;

/**
 * Created by Vinixz on 12/22/2017.
 */

public class NotifResponse extends CResponse{
    private ArrayList<Notif> data;

    public NotifResponse(String message, boolean status) {
        super(message, status);
    }

    public ArrayList<Notif> getData() {
        return data;
    }

    public void setData(ArrayList<Notif> data) {
        this.data = data;
    }
}
