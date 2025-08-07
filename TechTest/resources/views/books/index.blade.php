@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Book List Pertamina University</h2>
    <a href="{{ route('books.form') }}" class="btn btn-primary mb-3">Tambah Buku</a>
    <table class="table" id="books-table">
        <thead>
            <tr>
                <th>Book Code</th>
                <th>Book Title</th>
                <th>Book Author</th>
                <th>Category</th>
                <th>Year Published</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script>
fetch('/api/books')
    .then(res => res.json())
    .then(data => {
        const tbody = document.querySelector('#books-table tbody');
        data.forEach(book => {
            tbody.innerHTML += `
                <td>${book.book_code}</td>
                <td>${book.book_title}</td>
                <td>${book.book_author}</td>
                <td>${book.category.category_name}</td>
                <td>${book.year_published}</td>`;
        });
    });

function deleteBook(id) {
    if(confirm('Yakin hapus?')) {
        fetch('/api/books/' + id, { method: 'DELETE' })
            .then(() => location.reload());
    }
}
</script>
@endsection
