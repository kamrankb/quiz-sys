<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandSettings;
use App\Models\CountryCurrencies;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QuickNotify;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


class BrandSettingsController extends Controller
{
    function __construct()
    {
        $this->brandsettingsimagepath = 'backend/assets/images/weblogos/';

        $this->faqsimagepath = 'backend/assets/images/faqs/';
        //$this->middleware('permission:Faq-Create|Faq-Edit|Faq-View|Faq-Delete', ['only' => ['index','store']]);

    }

    // start logo & favicon
    public function form()
    {
        $data["logo"] = BrandSettings::where("key_name", '=', "logo")->first();
        $data["logo_white"] = BrandSettings::where("key_name", '=', "logo_white")->first();
        $data["favicon"] = BrandSettings::where("key_name", '=', "favicon")->first();

        return view('admin.brandsettings.brandsettinglogos', $data);
    }

    public function general_setting()
    {
        $data["logo"] = BrandSettings::where("key_name", '=', "logo")->first();
        $data["logo_white"] = BrandSettings::where("key_name", '=', "logo_white")->first();
        $data["favicon"] = BrandSettings::where("key_name", '=', "favicon")->first();
        $data["company_alias"] = BrandSettings::where("key_name", '=', "company_alias")->first();
        $data["company_name"] = BrandSettings::where("key_name", '=', "company_name")->first();
        $data["company_phone"] = BrandSettings::where("key_name", '=', "company_phone")->first();
        $data["company_email"] = BrandSettings::where("key_name", '=', "company_email")->first();
        $data["company_address"] = BrandSettings::where("key_name", '=', "company_address")->first();
        $data["social_facebook"] = BrandSettings::where("key_name", '=', "social_facebook")->first();
        $data["social_instagram"] = BrandSettings::where("key_name", '=', "social_instagram")->first();
        $data["social_twitter"] = BrandSettings::where("key_name", '=', "social_twitter")->first();
        $data["social_youtube"] = BrandSettings::where("key_name", '=', "social_youtube")->first();
        $data["social_linkedin"] = BrandSettings::where("key_name", '=', "social_linkedin")->first();
        $data["primary_color"] = BrandSettings::where("key_name", '=', "primary_color")->first();
        $data["secondary_color"] = BrandSettings::where("key_name", '=', "secondary_color")->first();
        $data["default_customer_password"] = BrandSettings::where("key_name", '=', "default_customer_password")->first();
        return view('admin.brandsettings.general-setting', $data);
    }

    public function store(Request $request)
    {
        $valid =  $request->validate([
            'logo' => 'image|mimes:png|max:2048',
            'logo_white' => 'image|mimes:png|max:2048',
            'favicon' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($valid) {
            if ($request->hasFile('logo')) {
                $logo = BrandSettings::where("key_name", '=', "logo")->first();

                if ($logo) {
                    $logo = BrandSettings::find($logo->id);
                    $logo->key_name = 'logo';
                    $image = $request->file('logo');
                    $imagename = 'logo.' . $image->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $image->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $logo->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $logo->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Company Logo",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $logo = new BrandSettings();

                    $logo->key_name = 'logo';
                    $image = $request->file('logo');
                    $imagename = 'logo.' . $image->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $image->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $logo->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $logo->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added new Company Logo",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->hasFile('logo_white')) {
                $logo_white = BrandSettings::where("key_name", '=', "logo_white")->first();

                if ($logo_white) {
                    $logo_white = BrandSettings::find($logo_white->id);
                    $logo_white->key_name = 'logo_white';
                    $logo = $request->file('logo_white');
                    $imagename = 'logo_white.' . $logo->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $logo->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $logo_white->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $logo_white->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Company Logo White",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $logo_white = new BrandSettings();

                    $logo_white->key_name = 'logo_white';
                    $logo = $request->file('logo_white');
                    $imagename = 'logo_white.' . $logo->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $logo->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $logo_white->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $logo_white->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added new Company Logo White",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->hasFile('favicon')) {
                $favicon = BrandSettings::where("key_name", '=', "favicon")->first();

                if ($favicon) {
                    $favicon = BrandSettings::find($favicon->id);
                    $favicon->key_name = 'favicon';
                    $image = $request->file('favicon');
                    $imagename = 'favicon.' . $image->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $image->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $favicon->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $favicon->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Company favicon",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $favicon = new BrandSettings();

                    $favicon->key_name = 'favicon';
                    $image = $request->file('favicon');
                    $imagename = 'favicon.' . $image->getClientOriginalExtension();
                    $image_destinationPath = public_path($this->brandsettingsimagepath);
                    $image->move($image_destinationPath, $imagename);
                    $imagename = $this->brandsettingsimagepath . $imagename;
                    $favicon->key_value = $imagename;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $favicon->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added new Company favicon",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            Session::flash('success', 'Logo has been successfully Save.');
            return redirect()->back()->with('success', 'Logo has been successfully Save.');
        } else {
            return redirect()->back();
        }
    }

    public function themestore(Request $request)
    {
        $valid =  $request->validate([
            'primary_color' => 'nullable',
            'secondary_color' => 'nullable',
            'default_customer_password' => 'nullable',
        ]);

        if ($valid) {
            if ($request->primary_color) {
                $primary_color = BrandSettings::where("key_name", '=', "primary_color")->first();

                if ($primary_color) {
                    $primary_color = BrandSettings::find($primary_color->id);
                    $primary_color->key_name = 'primary_color';
                    $primary_color->key_value = $request->primary_color;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $primary_color->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Alias",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $primary_color = new BrandSettings();

                    $primary_color->key_name = 'primary_color';
                    $primary_color->key_value = $request->primary_color;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $primary_color->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Theme Primary Color",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->secondary_color) {
                $secondary_color = BrandSettings::where("key_name", '=', "secondary_color")->first();

                if ($secondary_color) {
                    $secondary_color = BrandSettings::find($secondary_color->id);
                    $secondary_color->key_name = 'secondary_color';
                    $secondary_color->key_value = $request->secondary_color;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $secondary_color->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Name",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $secondary_color = new BrandSettings();

                    $secondary_color->key_name = 'secondary_color';
                    $secondary_color->key_value = $request->secondary_color;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $secondary_color->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Theme Secondary color",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->default_customer_password) {
                $default_customer_password = BrandSettings::where("key_name", '=', "default_customer_password")->first();

                if ($default_customer_password) {
                    $default_customer_password = BrandSettings::find($default_customer_password->id);
                    $default_customer_password->key_name = 'default_customer_password';
                    $default_customer_password->key_value = $request->default_customer_password;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $default_customer_password->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Name",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $default_customer_password = new BrandSettings();

                    $default_customer_password->key_name = 'default_customer_password';
                    $default_customer_password->key_value = $request->default_customer_password;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $default_customer_password->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Theme Secondary color",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            Session::flash('success', 'Theme has been successfully Save.');
            return redirect()->back()->with('success', 'Theme has been successfully Save.');
        } else {
            return redirect()->back();
        }
    }
    // end logo & favicon

    // start contactin formation

    public function contactinformationstore(Request $request)
    {
        $valid =  $request->validate([
            'company_alias' => 'nullable',
            'company_name' => 'nullable',
            'company_phone' => 'nullable',
            'company_email' => 'nullable',
            'company_address' => 'nullable',
        ]);

        if ($valid) {
            if ($request->company_alias) {
                $company_alias = BrandSettings::where("key_name", '=', "company_alias")->first();

                if ($company_alias) {
                    $company_alias = BrandSettings::find($company_alias->id);
                    $company_alias->key_name = 'company_alias';
                    $company_alias->key_value = $request->company_alias;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $company_alias->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Alias",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $company_alias = new BrandSettings();

                    $company_alias->key_name = 'company_alias';
                    $company_alias->key_value = $request->company_alias;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $company_alias->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Contact Information Company Alias",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->company_name) {
                $company_name = BrandSettings::where("key_name", '=', "company_name")->first();

                if ($company_name) {
                    $company_name = BrandSettings::find($company_name->id);
                    $company_name->key_name = 'company_name';
                    $company_name->key_value = $request->company_name;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $company_name->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Name",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $company_name = new BrandSettings();

                    $company_name->key_name = 'company_name';
                    $company_name->key_value = $request->company_name;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $company_name->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Contact Information Company Name",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->company_phone) {
                $phone = BrandSettings::where("key_name", '=', "company_phone")->first();

                if ($phone) {
                    $phone = BrandSettings::find($phone->id);
                    $phone->key_name = 'company_phone';
                    $phone->key_value = $request->company_phone;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $phone->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Phone",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $phone = new BrandSettings();

                    $phone->key_name = 'company_phone';
                    $phone->key_value = $request->company_phone;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $phone->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Contact Information Company Phone",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->company_email) {
                $email = BrandSettings::where("key_name", '=', "company_email")->first();

                if ($email) {
                    $email = BrandSettings::find($email->id);
                    $email->key_name = 'company_email';
                    $email->key_value = $request->company_email;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $email->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Contact Information Company Email",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $email = new BrandSettings();
                    $email->key_name = 'company_email';
                    $email->key_value = $request->company_email;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $email->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Contact Information Company Email",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->company_address) {
                $address = BrandSettings::where("key_name", '=', "company_address")->first();

                if ($address) {
                    $address = BrandSettings::find($address->id);
                    $address->key_name = 'company_address';
                    $address->key_value = $request->company_address;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $address->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated  Contact Information Company Address",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $address = new BrandSettings();
                    $address->key_name = 'company_address';
                    $address->key_value = $request->company_address;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $address->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Contact Information Company Address",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            Session::flash('success', 'Contact Information has been successfully Save.');
            return redirect()->back()->with('success', 'Contact Information has been successfully Save.');
        } else {
            return redirect()->back();
        }
    }
    // end contactin formation

    // start social link

    public function sociallinkstore(Request $request)
    {
        $valid =  $request->validate([
            'social_facebook' => 'nullable',
            'social_instagram' => 'nullable',
            'social_twitter' => 'nullable',
            'social_youtube' => 'nullable',
            'social_linkedin' => 'nullable',
        ]);

        if ($valid) {
            if ($request->social_facebook) {
                $social_facebook = BrandSettings::where("key_name", '=', "social_facebook")->first();

                if ($social_facebook) {
                    $social_facebook = BrandSettings::find($social_facebook->id);
                    $social_facebook->key_name = 'social_facebook';
                    $social_facebook->key_value = $request->social_facebook;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_facebook->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Social Links Company Facebook",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $social_facebook = new BrandSettings();
                    $social_facebook->key_name = 'social_facebook';
                    $social_facebook->key_value = $request->social_facebook;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_facebook->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Social Links Company Facebook",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->social_instagram) {
                $social_instagram = BrandSettings::where("key_name", '=', "social_instagram")->first();

                if ($social_instagram) {
                    $social_instagram = BrandSettings::find($social_instagram->id);
                    $social_instagram->key_name = 'social_instagram';
                    $social_instagram->key_value = $request->social_instagram;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_instagram->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated Social Links Company Instagram",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $social_instagram = new BrandSettings();
                    $social_instagram->key_name = 'social_instagram';
                    $social_instagram->key_value = $request->social_instagram;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_instagram->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Social Links Company Instagram",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->social_twitter) {
                $social_twitter = BrandSettings::where("key_name", '=', "social_twitter")->first();

                if ($social_twitter) {
                    $social_twitter = BrandSettings::find($social_twitter->id);
                    $social_twitter->key_name = 'social_twitter';
                    $social_twitter->key_value = $request->social_twitter;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_twitter->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated  Social Links Company Twitter",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $twitter = new BrandSettings();
                    $twitter->key_name = 'social_twitter';
                    $twitter->key_value = $request->social_twitter;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $twitter->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Social Links Company Twitter",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->social_youtube) {
                $social_youtube = BrandSettings::where("key_name", '=', "social_youtube")->first();

                if ($social_youtube) {
                    $social_youtube = BrandSettings::find($social_youtube->id);
                    $social_youtube->key_name = 'social_youtube';
                    $social_youtube->key_value = $request->social_youtube;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_youtube->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated  Social Links Company Youtube",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $social_youtube = new BrandSettings();
                    $social_youtube->key_name = 'social_youtube';
                    $social_youtube->key_value = $request->social_youtube;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_youtube->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Social Links Company Youtube",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            if ($request->social_linkedin) {
                $social_linkedin = BrandSettings::where("key_name", '=', "social_linkedin")->first();

                if ($social_linkedin) {
                    $social_linkedin = BrandSettings::find($social_linkedin->id);
                    $social_linkedin->key_name = 'social_linkedin';
                    $social_linkedin->key_value = $request->social_linkedin;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_linkedin->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Updated  Social Links Company Linkedin",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                } else {
                    $social_linkedin = new BrandSettings();
                    $social_linkedin->key_name = 'social_linkedin';
                    $social_linkedin->key_value = $request->social_linkedin;
                    $management = User::role(['Admin', 'Brand Manager'])->get();
                    $management->pluck('id');
                    $social_linkedin->save();

                    $notify = array(
                        "performed_by" => Auth::user()->id,
                        "title" => "Added New  Social Links Company Linkedin",
                        "desc" => array(
                            "added_title" => $request->input('key_value'),
                        )
                    );
                    Notification::send($management, new QuickNotify($notify));
                }
            }

            Session::flash('success', 'Social Links has been successfully Save.');
            return redirect()->back()->with('success', 'Social Links has been successfully Save.');
        } else {
            return redirect()->back();
        }
    }
    // end social link

    
}
