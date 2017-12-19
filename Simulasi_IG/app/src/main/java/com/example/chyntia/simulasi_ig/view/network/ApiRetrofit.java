package com.example.chyntia.simulasi_ig.view.network;

import okhttp3.OkHttpClient;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

/**
 * Created by Vinixz on 9/30/2017.
 */

public class ApiRetrofit {
    public static final String URL = "http://192.168.8.106:8080/PMD/api/assets/images/uploaded/";
    public static final String BASE_URL = "http://192.168.8.106:8080/PMD/api/api/";
    public static Retrofit retrofit;

    public static Retrofit getApiClient(){

        if(retrofit == null){
            HttpLoggingInterceptor interceptor = new HttpLoggingInterceptor();
            interceptor.setLevel(HttpLoggingInterceptor.Level.BODY);
            OkHttpClient client = new OkHttpClient.Builder().addInterceptor(interceptor).build();
            
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(client)
                    .build();
        }
        return retrofit;
    }
}
