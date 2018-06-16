<table class="table table-borderless">
    <colgroup>
        <col style="width: 33%">
        <col style="width: 33%">
        <col style="width: 33%">
    </colgroup>
    <tbody>
        <tr>
            <th class="text-left" scope="col">Price</th>
            <th class="text-center" scope="col">Amount</th>
            <th class="text-right" scope="col">Total</th>
        </tr>
    </tbody>
</table>

<div id="order-book-sells" class="table-responsive">
    <table  class="table table-borderless table-striped">
        <tbody>
            <?php foreach ($buyOrders as $order): ?>
                <?php for ($i=0; $i < 50; $i++): ?>
                    <tr class="selltext">
                        <td class="text-left">
                            <span class="clickable" onClick="setPriceOrder('<?php echo $order['price']; ?>')"><?php echo $order['price']; ?></span>
                        </td>
                        <td class="text-center">
                            <span class="clickable" onClick="setAmountOrder('<?php echo $order['amount']; ?>')"><?php echo $order['amount']; ?></span>
                        </td>
                        <td class="text-right"><?php echo $order['price']; ?></td>
                    </tr>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="order-book-buys" class="table-responsive">
    <table  class="table table-borderless table-striped">
        <tbody>
            <?php foreach ($sellOrders as $order): ?>
                <?php for ($i=0; $i < 50; $i++): ?>
                    <tr class="buytext">
                        <td class="text-left">
                            <span class="clickable" onClick="setPriceOrder('<?php echo $order['price']; ?>')"><?php echo $order['price']; ?></span>
                        </td>

                        <td class="text-center">
                            <span class="clickable" onClick="setAmountOrder('<?php echo $order['amount']; ?>')"><?php echo $order['amount']; ?></span>
                        </td>
                        <td class="text-right"><?php echo $order['price']; ?></td>
                    </tr>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
