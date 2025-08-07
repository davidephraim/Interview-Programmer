@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add Book Pertamina University</h2>
    <form id="book-form">
        <input type="text" id="book_title" placeholder="Book Title" class="form-control mb-2" required>
        <input type="text" id="book_author" placeholder="Book Author" class="form-control mb-2" required>
        <select id="category" class="form-control mb-2"></select>
        <select id="year_published" class="form-control mb-2">
            @for($year = 1990; $year <= date('Y'); $year++)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>
fetch('/api/categories')
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById('category');
        data.forEach(c => {
            select.innerHTML += `<option value="${c.id}">${c.category_name}</option>`;
        });
    });

document.getElementById('book-form').addEventListener('submit', e => {
    e.preventDefault();
    fetch('/api/books', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            book_title: document.getElementById('book_title').value,
            book_author: document.getElementById('book_author').value,
            category_id: document.getElementById('category').value,
            year_published: document.getElementById('year_published').value
        })
    }).then(() => location.href = '/books');
});
</script>
@endsection
