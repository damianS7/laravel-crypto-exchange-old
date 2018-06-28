<div id="pairs">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">BTC</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">ETH</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">BTX</a>
        </li>
        <li class="nav-item">
            <input id="search_coin" class="form-control form-control-sm" aria-label="" type="text" value="" placeholder="Search a coin" onClick="doSearch()">
        </li>
    </ul>

    <div id="pair-menu" class="">
        <table id="table-pair-menu" class="table table-striped table-responsive table-borderless">
            <colgroup>
                <col style="width: 30%">
                <col style="width: 30%">
                <col style="width: 40%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-left" scope="col">Price</th>
                    <th class="text-left" scope="col">Amount</th>
                    <th class="text-right" scope="col">Filled</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($markets as $pair)
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                <tr data-id="{{ $pair->id }}">
                    <td class="text-left {{ $pair->symbol }}-price">{{ $pair->symbol }}</td>
                    <td class="text-left amount">{{ $pair->symbol }}</td>
                    <td class="text-right date">{{ $pair->symbol }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
