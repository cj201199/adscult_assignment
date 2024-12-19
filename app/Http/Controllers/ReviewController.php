<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;
use View;

class ReviewController extends Controller
{
    public function addReview()
    {
        $books = Book::where('is_active', 1)->get();
        return view('pages.add-review', compact('books'));
    }

    public function storeReview(Request $request)
    {
        // dd(vars: Auth::user()->id);
        try {
            DB::beginTransaction();
            $userId = Auth::user()->id;
            $review = new Review();
            $review->book_id = $request->books;
            $review->user_id = $userId;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->save();
            DB::commit();

            return response()->json(['status' => 200, 'message' => 'Review has been added successfully!']);
        } catch (\Exception $e) {
            Log::error('storeReview function failed: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Review added failed. Please try again later.'], 500);
        }
    }

    public function editReview($id)
    {
        $review = Review::where('id', $id)->first();
        $books = Book::where('is_active', 1)->get();
        return view('pages.edit-review', compact('review', 'books'));
    }

    public function updateReview(Request $request)
    {
        try {
            $validated = $request->validate([
                'rating' => 'required|numeric|min:1|max:5',
                'review' => 'required|string',
            ]);
            DB::beginTransaction();
            $review = Review::where('id', $request->rating_id)->where('user_id', Auth::user()->id)->first();

            if ($review) {
                $review->book_id = $request->books;
                $review->rating = $request->rating;
                $review->review = $request->review;
                $review->save();
                DB::commit();

                return response()->json(['status' => 200, 'message' => 'Review updated successfully!']);
            } else {
                return response()->json(['status' => 401, 'message' => 'Review has not been created by you.']);
            }
        } catch (\Exception $e) {
            Log::error('updateReview function failed: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Review added failed. Please try again later.'], 500);
        }
    }

    public function deleteReview($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if ($review) {
            $review->delete();
            return response()->json(['status' => 200, 'message' => 'Review has been deleted successfully!']);
        } else {
            return response()->json(['status' => 401, 'message' => 'Review has not been created by you']);
        }
    }
}
