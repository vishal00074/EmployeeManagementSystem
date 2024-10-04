<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCoverLetterResumeFromCandidatesTable extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('cover_letter');
            $table->dropColumn('resume');
        });
    }

    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('cover_letter')->nullable();
            $table->string('resume')->nullable();
        });
    }
}
