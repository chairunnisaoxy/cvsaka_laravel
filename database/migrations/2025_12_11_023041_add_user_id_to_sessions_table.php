public function up()
{
Schema::table('sessions', function (Blueprint $table) {
$table->string('user_id')->nullable()->after('id');
});
}

public function down()
{
Schema::table('sessions', function (Blueprint $table) {
$table->dropColumn('user_id');
});
}