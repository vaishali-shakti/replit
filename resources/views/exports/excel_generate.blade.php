<table>
    <thead>
        <tr>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">S PERSON</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">ORDER NUMBER</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">DATE</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">BROKER</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">PARTY NAME</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">FIRM NAME</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">ADDRESS</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">COMPANY NAME</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">QUALITY</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">P.RATE</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">SB.RATE</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">SFG.RATE</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">BIM</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">BOX</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">KG</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">METER</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">TAR</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">DELIVERY</th>
            <th style="background-color: #3e733c; color: black; border: 1px solid #000; font-weight: bold;">BAKI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->sale_person) ? $order->sale_person : ''}}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ $order->order_number }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ display_date_formate($order->date) }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->broker) ? $order->broker : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->Sale_Party->firm_name) ? $order->Sale_Party->firm_name : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->billing_name) ? $order->billing_name.' ('.$order->firm_name.')' : $order->firm_name}}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ $order->delivery_address }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->Purchase_Company->firm_name) ? $order->Purchase_Company->firm_name : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ $order->qulity }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->pure_rate) ? ($order->pure_rate.(str_contains(strtoupper($order->pure_rate), 'ALL') ? '' :'++' )) : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->b_rate) ? $order->b_rate.'++' : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->total_sale_rate) ? number_format($order->total_sale_rate,2) : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->beam) ? $order->beam : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->box) ? $order->box : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->quntity) ? $order->quntity : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->mtr) ? $order->mtr : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ isset($order->tar) ? $order->tar : '' }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ delivered_order($order->id) }}</td>
                <td style="{{ $order->close_query == 1 ? 'background-color: yellow; color: black; border: 1px solid #000;' : 'background-color: #b5c6eb; color: black; border: 1px solid #000;' }}">{{ pending_quantity_order($order->id) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>