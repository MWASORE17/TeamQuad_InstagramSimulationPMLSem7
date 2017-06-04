package com.example.chyntia.tes;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

/**
 * Created by Chyntia on 6/4/2017.
 */

public class MyPagerAdapter extends FragmentPagerAdapter {
    final int PAGE_COUNT = 3;
    private String tabTitles[] = new String[] { "satu", "dua", "tiga" };
    private Context context;
    public MyPagerAdapter(FragmentManager fm, Context context) {
        super(fm);
        this.context = context;
    }

    @Override
    public Fragment getItem(int pos) {

        switch(pos) {
            case 0: return FirstFragment.newInstance(pos);
            case 1: return SecondFragment.newInstance(pos);
            case 2: return ThirdFragment.newInstance(pos);
            default: return null;
        }
    }

    @Override
    public int getCount() {
        return PAGE_COUNT;
    }
    // Returns the page title for the top indicator
    @Override
    public CharSequence getPageTitle(int position) {
        return tabTitles[position];
    }
}
