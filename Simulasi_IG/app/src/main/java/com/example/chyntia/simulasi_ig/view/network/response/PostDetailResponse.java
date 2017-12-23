package com.example.chyntia.simulasi_ig.view.network.response;

import com.example.chyntia.simulasi_ig.view.network.model.PostDetail;

/**
 * Created by Vinixz on 12/20/2017.
 */

public class PostDetailResponse extends CResponse {
    private PostDetail data;

    public PostDetailResponse(String message, boolean status) {
        super(message, status);
    }

    public PostDetail getData() {
        return data;
    }

    public void setData(PostDetail data) {
        this.data = data;
    }
}
