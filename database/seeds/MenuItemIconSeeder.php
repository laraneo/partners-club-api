<?php

use Illuminate\Database\Seeder;

use App\MenuItemIcon;
class MenuItemIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $data = [
            [ 'name' => 'AccountBoxIcon' , 'slug' => 'AccountBoxIcon', 'description' => 'AccountBoxIcon' , 'import' => "@material-ui/icons/AccountBox'" ],
            [ 'name' => 'AccountCircleIcon' , 'slug' => 'AccountCircleIcon', 'description' => 'AccountCircleIcon' , 'import' => "@material-ui/icons/AccountCircle'" ],
            [ 'name' => 'SecurityIcon' , 'slug' => 'SecurityIcon', 'description' => 'SecurityIcon' , 'import' => "@material-ui/icons/Security'" ],
            [ 'name' => 'DashboardIcon' , 'slug' => 'DashboardIcon', 'description' => 'DashboardIcon' , 'import' => "@material-ui/icons/Dashboard" ],
            [ 'name' => 'VerifiedUserIcon' , 'slug' => 'VerifiedUserIcon', 'description' => 'VerifiedUserIcon' , 'import' => "@material-ui/icons/VerifiedUser" ],
            [ 'name' => 'ContactPhoneIcon' , 'slug' => 'ContactPhoneIcon', 'description' => 'ContactPhoneIcon' , 'import' => "@material-ui/icons/ContactPhone" ],
            [ 'name' => 'NotesIcon' , 'slug' => 'NotesIcon', 'description' => 'NotesIcon' , 'import' => "@material-ui/icons/Notes" ],
            [ 'name' => 'InsertDriveFileIcon' , 'slug' => 'InsertDriveFileIcon', 'description' => 'InsertDriveFileIcon' , 'import' => "@material-ui/icons/InsertDriveFile" ],
            [ 'name' => 'ListIcon' , 'slug' => 'ListIcon', 'description' => 'ListIcon' , 'import' => "@material-ui/icons/List" ],
            [ 'name' => 'RecordVoiceOverIcon' , 'slug' => 'RecordVoiceOverIcon', 'description' => 'RecordVoiceOverIcon' , 'import' => "@material-ui/icons/RecordVoiceOver" ],
            [ 'name' => 'MenuOpenIcon' , 'slug' => 'MenuOpenIcon', 'description' => 'MenuOpenIcon' , 'import' => "@material-ui/icons/MenuOpen" ],
            [ 'name' => 'PlaylistAddCheckIcon' , 'slug' => 'PlaylistAddCheckIcon', 'description' => 'PlaylistAddCheckIcon' , 'import' => "@material-ui/icons/PlaylistAddCheck" ],
            [ 'name' => 'LowPriorityIcon' , 'slug' => 'LowPriorityIcon', 'description' => 'LowPriorityIcon' , 'import' => "@material-ui/icons/LowPriority" ],
            [ 'name' => 'FormatListNumberedIcon' , 'slug' => 'FormatListNumberedIcon', 'description' => 'FormatListNumberedIcon' , 'import' => "@material-ui/icons/FormatListNumbered" ],
            [ 'name' => 'PaymentIcon' , 'slug' => 'PaymentIcon', 'description' => 'PaymentIcon' , 'import' => "@material-ui/icons/Payment" ],
            [ 'name' => 'AccountBalanceIcon' , 'slug' => 'AccountBalanceIcon', 'description' => 'AccountBalanceIcon' , 'import' => "@material-ui/icons/AccountBalance" ],
            [ 'name' => 'CreditCardIcon' , 'slug' => 'CreditCardIcon', 'description' => 'CreditCardIcon' , 'import' => "@material-ui/icons/CreditCard" ],
            [ 'name' => 'AccountTreeIcon' , 'slug' => 'AccountTreeIcon', 'description' => 'AccountTreeIcon' , 'import' => "@material-ui/icons/AccountTree" ],
            [ 'name' => 'PublicIcon' , 'slug' => 'PublicIcon', 'description' => 'PublicIcon' , 'import' => "@material-ui/icons/Public" ],
            [ 'name' => 'WcIcon' , 'slug' => 'WcIcon', 'description' => 'WcIcon' , 'import' => "@material-ui/icons/Wc" ],
            [ 'name' => 'WidgetsIcon' , 'slug' => 'WidgetsIcon', 'description' => 'WidgetsIcon' , 'import' => "@material-ui/icons/Widgets" ],
            [ 'name' => 'PermDataSettingIcon' , 'slug' => 'PermDataSettingIcon', 'description' => 'PermDataSettingIcon' , 'import' => "@material-ui/icons/PermDataSetting" ],
            [ 'name' => 'CreateNewFolderIcon' , 'slug' => 'CreateNewFolderIcon', 'description' => 'CreateNewFolderIcon' , 'import' => "@material-ui/icons/CreateNewFolder" ],
            [ 'name' => 'AccessTimeIcon' , 'slug' => 'AccessTimeIcon', 'description' => 'AccessTimeIcon' , 'import' => "@material-ui/icons/AccessTime" ],
            [ 'name' => 'ErrorOutlineIcon' , 'slug' => 'ErrorOutlineIcon', 'description' => 'ErrorOutlineIcon' , 'import' => "@material-ui/icons/ErrorOutline" ],
            [ 'name' => 'AnnouncementIcon' , 'slug' => 'AnnouncementIcon', 'description' => 'AnnouncementIcon' , 'import' => "@material-ui/icons/Announcement" ],
            [ 'name' => 'AssignmentLateIcon' , 'slug' => 'AssignmentLateIcon', 'description' => 'AssignmentLateIcon' , 'import' => "@material-ui/icons/AssignmentLate" ],
            [ 'name' => 'ViewListIcon' , 'slug' => 'ViewListIcon', 'description' => 'ViewListIcon' , 'import' => "@material-ui/icons/ViewList" ],
            [ 'name' => 'CakeIcon' , 'slug' => 'CakeIcon', 'description' => 'CakeIcon' , 'import' => "@material-ui/icons/Cake" ],
            [ 'name' => 'CategoryIcon' , 'slug' => 'CategoryIcon', 'description' => 'CategoryIcon' , 'import' => "@material-ui/icons/Category" ],
            [ 'name' => 'DescriptionIcon' , 'slug' => 'DescriptionIcon', 'description' => 'Description' , 'import' => "@material-ui/icons/Description" ],
            ];
            foreach ($data as $element) {
                MenuItemIcon::create([
                    'name' => $element['name'],
                    'description' => $element['description'],
                    'slug' => $element['slug'],
                    'import' => $element['import'],
                ]);
            }
    }
}
