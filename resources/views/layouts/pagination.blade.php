{{-- @section('pagination-numbering')
    <td>{{ $paginated_list['loop']->iteration + (10 * ($paginated_list['current_page']-1)) }}</td>
@endsection --}}

<!--begin: Pagination -->
<div class="float-right">
    Showing {{$paginated_list['from']}} to {{$paginated_list['to']}} of {{$paginated_list['total']}} entries

    @if($paginated_list['prev_page_url'] == null && $paginated_list['next_page_url'] == null)
    @elseif($paginated_list['prev_page_url'] == null)
        <a href="#" class="btn btn-secondary disabled"> << </a>
        <a href="{{url($paginated_list['url'].$paginated_list['next_page_url'])}}" class="btn btn-primary"> >> </a>
    @elseif($paginated_list['next_page_url'] == null)
        <a href="{{url($paginated_list['url'].$paginated_list['prev_page_url'])}}" class=" btn btn-primary"> << </a>
        <a href="#" class="btn btn-secondary disabled"> >> </a>
    @else
        <a href="{{url($paginated_list['url'].$paginated_list['prev_page_url'])}}" class="btn btn-primary"> << </a>
        <a href="{{url($paginated_list['url'].$paginated_list['next_page_url'])}}" class="btn btn-primary"> >> </a>
    @endif
</div>
<!--end: Pagination -->
