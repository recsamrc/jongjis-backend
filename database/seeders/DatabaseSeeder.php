<?php

namespace Database\Seeders;

use App\Models\BikeCategory;
use App\Models\Shop;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // INSERT INTO `tbl_user_groups` (`id`, `group_name`, `description`, `allow_add`, `allow_edit`, `allow_delete`, `allow_print`, `allow_import`, `allow_export`)
        // VALUES (1, 'admin', 'Group for administators.', 1, 1, 1, 1, 1, 1);
        $adminGroup = UserGroup::create([
            'group_name' => 'admin',
            'description' => 'Group for admins.',
            'allow_add' => true,
            'allow_edit' => true,
            'allow_delete' => true,
            'allow_print' => true,
            'allow_import' => true,
            'allow_export' => true,
        ]);

        // INSERT INTO `tbl_users` (`id`, `email`, `password`, `username`, `fullname`, `contact`, `user_group_id`, `status`)
        // VALUES (1, 'admin@admin.com', MD5('lovelove'), 'admin', 'admin', '012345678', 1, `status`);
        $admin = User::create([
            'email' => 'admin@admin.com',
            'password' => Hash::make('lovelove'),
            'username' => 'admin',
            'fullname' => 'admin',
            'contact' => '012345678',
            'user_group_id' => $adminGroup->id,
            'status' => true,
        ]);
        // INSERT INTO `tbl_shops` (`id`, `shop_name`, `owner_name`, `address`, `email_address`, `contact_no`, `website`, `updated_by`)
        // VALUES (1, 'Shop 1', 'Shop Owner 1', 'Shop 1 location', 'shop1@shop.com', '012345678', 'https://shop1.com', 1);
        Shop::create([
            'shop_name' => 'Shop 1',
            'owner_name' => 'Shop Owner 1',
            'address' => 'Shop 1 location',
            'email_address' => 'shop1@shop.com',
            'contact_no' => '012345678',
            'website' => 'https://shop1.com',
            'updated_by' => $admin->id,
        ]);

        // INSERT INTO `tbl_bike_categories` (`id`, `category_name`, `description`)
        // VALUES (1, 'Category 1', 'Description of category 1');
        BikeCategory::create([
            'category_name' => 'Japanese Bike',
            'description' => 'Bikes from Japan.'
        ]);
        BikeCategory::create([
            'category_name' => 'American Bike',
            'description' => 'Bikes from the US.'
        ]);
    }
}
