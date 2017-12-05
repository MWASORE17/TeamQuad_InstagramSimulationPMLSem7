package com.example.chyntia.simulasi_ig.view.network.response;

/**
 * Created by Vinixz on 11/29/2017.
 */

public class CResponse {

    private String message;
    private boolean status;

    public CResponse(String message, boolean status) {
        this.message = message;
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }
}
