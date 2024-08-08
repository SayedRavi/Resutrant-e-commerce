<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AppDownloadSection;
use App\Models\BannerSlider;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Contact;
use App\Models\Counter;
use App\Models\Coupon;
use App\Models\DailyOffer;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\TermsAndConditions;
use App\Models\Testimoinal;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Laravel\Reverb\Servers\Reverb\Http\Route;
use PHPUnit\Exception;

class FrontendContoller extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $sectionTitle = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $categories = Category::where(['show_at_home'=> 1, 'status'=>1])->get();
        $dailyOffers = DailyOffer::where('status', 1)->take(6)->get();
        $bannerSliders = BannerSlider::where('status', 1)->latest()->take(6)->get();
        $chefs = Chef::where(['status'=> 1, 'show_at_home' => 1])->take(8)->get();
        $appDownload = AppDownloadSection::first();
        $testimonials = Testimoinal::where(['status'=> 1, 'show_at_home' => 1])->get();
        $counter = Counter::first();
        $latestBlogs = Blog::withCount(['comments'=> function ($query){
            $query->where('status', 1);
        }])->with('category', 'user')->where('status', 1)->latest()->take(3)->get();
        return view('frontend.home.index',
            compact(
                'sliders',
                'sectionTitle',
                'whyChooseUs',
                'categories',
                'dailyOffers',
                'bannerSliders',
                'chefs',
                'appDownload',
                'testimonials',
                'counter',
                'latestBlogs'
            ));
    }

    public function chef()
    {
        $chefs = Chef::where(['status'=> 1, 'show_at_home' => 1])->paginate(8);
        return view('frontend.pages.chefs', compact('chefs'));
    }

    public function testimonial()
    {
        $testimonials = Testimoinal::where(['status'=> 1, 'show_at_home' => 1])->paginate(8);
        return view('frontend.pages.testimonials', compact('testimonials'));
    }

    public function about()
    {
        $about = About::first();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $sectionTitle = $this->getSectionTitles();
        $chefs = Chef::where(['status'=> 1, 'show_at_home' => 1])->take(8)->get();
        $counter = Counter::first();
        $testimonials = Testimoinal::where(['status'=> 1, 'show_at_home' => 1])->get();
        return view('frontend.pages.about', compact('about', 'whyChooseUs', 'sectionTitle', 'chefs', 'counter', 'testimonials'));
    }

    public function privacyPolicy()
    {
        $privacy = PrivacyPolicy::first();
        return view('frontend.pages.privacy-policy', compact('privacy'));
    }
    public function termsAndConditions()
    {
        $terms = TermsAndConditions::first();
        return view('frontend.pages.terms-and-conditions', compact('terms'));
    }

    public function contact()
    {
        $contact = Contact::first();
        return view('frontend.pages.contact', compact('contact'));
    }

    public function blogs(Request $request)
    {
        $blogs = Blog::withCount(['comments'=> function($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1);

        if ($request->has('search') && $request->filled('search')) {
            $blogs->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%'.$request->search.'%')
                ->orWhere('description', 'LIKE', '%'.$request->search.'%');
            });
        }
        if ($request->has('category') && $request->filled('category')) {
            $blogs->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }
        $blogs = $blogs->latest()->paginate(8);
        $categories = BlogCategory::where('status', 1)->get();
        return view('frontend.pages.blog', compact('blogs', 'categories'));
    }

    public function blogDetails(string $slug)
    {
        $blog = Blog::with(['user'])->where('slug', $slug)->where('status', 1)->firstOrFail();
        $comments = $blog->comments()->where('status', 1)->orderBy('id', 'DESC')->paginate(15);
        $latestBlogs = Blog::select('id', 'title', 'slug', 'created_at','image')
            ->where('id','!=',$blog->id)
            ->where('status', 1)
            ->latest()->take(4)->get();
        $categories = BlogCategory::withCount(['blogs'=> function ($query) {
            $query->where('status', 1);
        }])->where('status',1)->get();

        $previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        return view('frontend.pages.blog-details', compact('blog','latestBlogs', 'categories', 'previousBlog', 'nextBlog', 'comments'));
    }

    public function blogCommentStore(Request $request, string $blog_id)
    {
        $request->validate([
            'comment' => 'required | string | max:500',
        ]);

        Blog::findOrFail($blog_id);
        BlogComment::create([
            'blog_id' => $blog_id,
            'user_id' => auth()->user()->id,
            'comment' => $request->comment
        ]);
        toastr()->success('Comment Added Successfully and waiting for approve');
        return redirect()->back();
    }
    public function getSectionTitles()
    {
        $keys = ['why_choose_top_title', 'why_choose_main_title', 'why_choose_sub_title',
            'daily_offer_top_title', 'daily_offer_main_title', 'daily_offer_sub_title',
            'chefs_section_top_title', 'chefs_section_main_title', 'chefs_section_sub_title',
            'testimonial_section_top_title', 'testimonial_section_main_title', 'testimonial_section_sub_title'];
        return SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
    }

    public function showProduct(String $slug)
    {
        $product = Product::with(['productImages','productSizes','productOptions'])->where(['slug'=>$slug, 'status'=> 1])->firstOrFail();
        $relatedProducts = Product::where('category_id',$product->category_id)
            ->where('id','!=', $product->id)->take(8)->latest()->get();
        return view('frontend.pages.show-product', compact('product','relatedProducts'));
    }

    public function loadProductModal($productId)
    {
        $product = Product::with(['productSizes','productOptions'])->findOrFail($productId);
        return view('frontend.layouts.ajax-files.product-popup-modal', compact('product'))->render();

    }

    public function applyCoupon(Request $request)
    {
        $subTotal = $request->subTotal;
        $code = $request->code;
        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon){
            return response(['message'=> 'Invalid Coupon!'], 422);
        }
        if ($coupon->quantity < 0){
            return response(['message'=> 'Coupon has been Redeemed'], 422);
        }
        if ($coupon->expire_date < now()){
            return response(['message'=> 'Coupon has Expired'], 422);
        }
        if ($coupon->discount_type == 'percent'){
            $discount = number_format($subTotal * ($coupon->discount/100), 2);
        }else if($coupon->discount_type == 'fixed'){
            $discount = number_format($coupon->discount, 2);
        }

        $final_total = $subTotal - $discount;
        session()->put('coupon', ['code'=> $request->code, 'discount'=> $discount]);
        return  response(['message' => 'Coupon Applied Successfully!',
            'discount'=> $discount,
            'finalTotal' => $final_total,
            'coupon_code' => $code
        ], 200);

    }

    public function destroyCoupon()
    {
        try {
            session()->forget('coupon');
            return response(['message' => 'Coupon has been deleted!', 'grand_cart_total'=>grandCartTotal()]);
        }catch (Exception $err)
        {
            return response(['message' => 'Something Went Wrong!']);
        }
    }
}
