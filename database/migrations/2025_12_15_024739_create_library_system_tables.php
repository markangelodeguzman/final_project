<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create CATEGORY table first (Book depends on it)
        Schema::create('category', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name');
        });

        // 2. Create PATRON table
        Schema::create('patron', function (Blueprint $table) {
            $table->id('patron_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('account_status')->default('active'); // active, suspended
        });

        // 3. Create LIBRARIAN table
        Schema::create('librarian', function (Blueprint $table) {
            $table->id('librarian_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_info')->nullable();
        });

        // 4. Create ADMINISTRATOR table
        Schema::create('administrator', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_info')->nullable();
        });

        // 5. Create BOOK table (Depends on Category)
        Schema::create('book', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('condition')->nullable(); // new, good, damaged
            $table->string('location')->nullable();
            $table->string('availability_status')->default('available'); // available, borrowed, maintenance

            $table->foreign('category_id')->references('category_id')->on('category')->onDelete('cascade');
        });

        // 6. Create BORROW table (Depends on Book, Patron, Librarian)
        Schema::create('borrow', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('patron_id');
            // Nullable because a request starts without a librarian assigning it yet
            $table->unsignedBigInteger('librarian_id')->nullable(); 
            
            $table->date('borrow_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('status')->default('pending'); // pending, active, returned, overdue

            $table->foreign('book_id')->references('book_id')->on('book')->onDelete('cascade');
            $table->foreign('patron_id')->references('patron_id')->on('patron')->onDelete('cascade');
            $table->foreign('librarian_id')->references('librarian_id')->on('librarian')->onDelete('set null');
        });

        // 7. Create PENALTY table (Depends on Borrow)
        Schema::create('penalty', function (Blueprint $table) {
            $table->id('penalty_id');
            $table->unsignedBigInteger('borrow_id');
            $table->decimal('amount', 10, 2);
            $table->date('date_applied');
            $table->string('remarks')->nullable();

            $table->foreign('borrow_id')->references('borrow_id')->on('borrow')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalty');
        Schema::dropIfExists('borrow');
        Schema::dropIfExists('book');
        Schema::dropIfExists('administrator');
        Schema::dropIfExists('librarian');
        Schema::dropIfExists('patron');
        Schema::dropIfExists('category');
    }
};