{{$items->links()}}
<br>
<table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Location Code</th>
                <th scope="col">Item Name</th>
                <th scope="col">Type</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Expire Date</th>
                <th scope="col">Created at</th>
                <th scope="col">Last Update</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody style="font-size: 12px;">
        @php $i = 1; @endphp
            @foreach($items as $detail)
            @if($detail->shop_id == Auth::user()->shop_id)
                @if($detail->product_id == null)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <th scope="row"> No Location Service </th>
                        <td>{{ $detail->deleteProduct->product_name }}</td>
                        <td>*</td>
                        <!-- <td>{{ round($detail->qty) }} {{ $detail->count_type }}</td> -->
                        <td>{{ $detail->qty }} {{ $detail->count_type }}</td>
                        <td>Rs.{{ $detail->unit_price }}</td>
                        <td>
                            @if($detail->expire_date == 'null')
                                N/A
                            @else
                                {{ $detail->expire_date }}
                            @endif
                        </td>
                        <td>{{ $detail->created_at->diffForHumans() }}</td>
                        <td>{{ $detail->updated_at->diffForHumans() }}</td>
                        <td>
                            @if($detail->remark == 'Deleted')
                            <span class="badge badge-pill badge-danger">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'Updated')
                            <span class="badge badge-pill badge-success">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'Discarded Items')
                            <span class="badge badge-pill badge-warning">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'sale')
                            <span class="badge badge-pill badge-success">**{{ $detail->remark }}**</span>
                            @else
                            <span class="badge badge-pill badge-primary">{{ $detail->remark }}</span>
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $i++ }}</td>
                        <th scope="row">{{ $detail->product->location_code }}</th>
                        <td>{{ $detail->product->company->company_name }}{{ $detail->product->product_name }}</td>
                        <td>**</td>
                        <!-- <td>{{ round($detail->qty) }} {{ $detail->count_type }}</td> -->
                        <td>{{ $detail->qty }} {{ $detail->count_type }}</td>
                        <td>Rs.{{ $detail->unit_price }}</td>
                        <td>
                            @if($detail->expire_date == null)
                                N/A
                            @else
                                {{ $detail->expire_date }}
                            @endif
                        </td>
                        <td>{{ $detail->created_at->diffForHumans() }}</td>
                        <td>{{ $detail->updated_at->diffForHumans() }}</td>
                        <td>
                            @if($detail->remark == 'Deleted')
                            <span class="badge badge-pill badge-danger">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'Updated')
                            <span class="badge badge-pill badge-success">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'Discarded Items')
                            <span class="badge badge-pill badge-warning">{{ $detail->remark }}</span>
                            @elseif($detail->remark == 'sale')
                            <span class="badge badge-pill badge-success">**{{ $detail->remark }}**</span>
                            @else
                            <span class="badge badge-pill badge-primary">{{ $detail->remark }}</span>
                            @endif
                        </td>
                    </tr>
                @endif
            @endif
            @endforeach
        </tbody>
    </table>