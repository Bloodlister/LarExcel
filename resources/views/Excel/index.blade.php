<form action="/" method="post">
    {{ csrf_field() }}
    <input type="text" name="cell_data" />
    <button type="submit">Submit</button>
</form>