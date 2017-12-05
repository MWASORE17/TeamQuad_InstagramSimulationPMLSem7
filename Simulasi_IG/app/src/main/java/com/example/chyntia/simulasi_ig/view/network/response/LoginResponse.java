package com.example.chyntia.simulasi_ig.view.network.response;

/**
 * Created by Vinixz on 12/5/2017.
 */

public class LoginResponse extends CResponse {
    private String data;

    public LoginResponse(String message, boolean status) {
        super(message, status);
    }

    public LoginResponse(String message, boolean status, String token) {
        super(message, status);
        this.data = token;
    }

    public String getToken() {
        return data;
    }

    public void setToken(String token) {
        this.data = token;
    }
}
