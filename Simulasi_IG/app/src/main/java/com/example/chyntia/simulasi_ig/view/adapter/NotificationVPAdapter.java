package com.example.chyntia.simulasi_ig.view.adapter;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import com.example.chyntia.simulasi_ig.view.fragment.user.TabFollowingFragment;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabFollowingViewFragment;
import com.example.chyntia.simulasi_ig.view.fragment.user.TabYouFragment;

/**
 * Created by Chyntia on 5/20/2017.
 */

public class NotificationVPAdapter extends FragmentPagerAdapter {
    final int PAGE_COUNT = 2;
    private String tabTitles[] = new String[] { "Following", "You" };
    private Context context;

    public NotificationVPAdapter(FragmentManager fm, Context context) {
        super(fm);
        this.context = context;
    }

    // Returns total number of pages
    @Override
    public int getCount() {
        return PAGE_COUNT;
    }

    // Returns the fragment to display for that page
    @Override
    public Fragment getItem(int position) {
        switch(position){
            case 0:
                return new TabFollowingFragment();
            case 1:
                return new TabYouFragment();
            default:
                return null;
        }
    }

    // Returns the page title for the top indicator
    @Override
    public CharSequence getPageTitle(int position) {
        return tabTitles[position];
    }
}
