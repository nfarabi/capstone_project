@hasMorePages($records)
<div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
        {{ $records->links() }}
    </ul>
</div>
@endhasMorePages
