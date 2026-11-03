<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AttachmentController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\AIController;


Route::prefix('v1')->group(function () {

    Route::post('/login', [
        AuthController::class,
        'login'
    ]);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/tickets', [
            TicketController::class,
            'index'
        ]);

        Route::get('/tickets/{ticket}', [
            TicketController::class,
            'show'
        ]);

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ]);

        Route::get('/user', function (Request $request) {
            return response()->json(
                $request->user()
            );
        });

        Route::post('/logout', [
            AuthController::class,
            'logout'
        ]);

        Route::post(
            '/tickets',
            [TicketController::class, 'store']
        );

        Route::put(
            '/tickets/{ticket}',
            [TicketController::class, 'update']
        );

        Route::delete(
            '/tickets/{ticket}',
            [TicketController::class, 'destroy']
        );

        Route::get(
            '/notifications',
            [NotificationController::class, 'index']
        );

        Route::patch(
            '/notifications/{notification}/read',
            [NotificationController::class, 'markAsRead']
        );

        Route::patch(
            '/notifications/read-all',
            [NotificationController::class, 'markAllAsRead']
        );

        Route::get(
            '/tickets/{ticket}/comments',
            [CommentController::class, 'index']
        );

        Route::post(
            '/tickets/{ticket}/comments',
            [CommentController::class, 'store']
        );

        Route::get(
            '/tickets/{ticket}/attachments',
            [AttachmentController::class, 'index']
        );

        Route::post(
            '/tickets/{ticket}/attachments',
            [AttachmentController::class, 'store']
        );

        Route::get(
            '/tickets/{ticket}/history',
            [HistoryController::class, 'index']
        );

        Route::post(
            '/ai/classify-ticket',
            [AIController::class, 'classifyTicket']
        );

        Route::get(
            '/tickets/{ticket}/summary',
            [AIController::class, 'summarizeTicket']
        );

        Route::get(
            '/tickets/{ticket}/suggest-reply',
            [AIController::class, 'suggestReply']
        );

        Route::get(
            '/tickets/{ticket}/closure-report',
            [AIController::class, 'closureReport']
        );

        Route::get(
            '/tickets/{ticket}/knowledge-article',
            [AIController::class, 'knowledgeArticle']
        );

        Route::post(
            '/tickets/{ticket}/knowledge-articles',
            [AIController::class,
            'generateKnowledgeArticle']
        );

        Route::get(
            '/knowledge-articles',
            [AIController::class,
            'listKnowledgeArticles']
        );

        Route::get(
            '/knowledge-articles/search',
            [AIController::class,
            'searchKnowledgeArticles']
        );

        Route::post(
            '/knowledge-articles/suggest',
            [AIController::class,
            'suggestKnowledgeArticles']
        );

    });
});