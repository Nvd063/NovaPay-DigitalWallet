 <div id="topUpModal" class="moverlay" style="display:none">
            <div class="msheet">
                <div class="mdrag"></div>
                <div class="mhdr"><h6>Add Money</h6><button class="mx" onclick="closeModal('topUpModal')">×</button></div>
                <form action="{{ route('topup.process') }}" method="POST">
                    @csrf
                    <div class="field-grp mt-3">
                        <label>Amount (PKR)</label>
                        <div class="field-wrap amt-wrap"><span class="fpre">Rs.</span><input type="number" name="amount" placeholder="0.00" min="100" required></div>
                    </div>
                    <button type="submit" class="btn-nova mt-3">Refill Wallet</button>
                </form>
            </div>
        </div>

        <div id="sendModal" class="moverlay" style="display:none">
            <div class="msheet">
                <div class="mdrag"></div>
                <div class="mhdr"><h6>Send Money</h6><button class="mx" onclick="closeModal('sendModal')">×</button></div>
                <form action="{{ route('transfer.process') }}" method="POST">
                    @csrf
                    <div class="field-grp">
                        <label>Bank Name</label>
                        <div class="field-wrap"><i class="fa-solid fa-building-columns fi"></i><input type="text" name="bank_name" placeholder="e.g. HBL, Easypaisa" required></div>
                    </div>
                    <div class="field-grp">
                        <label>Account / Phone</label>
                        <div class="field-wrap"><i class="fa-solid fa-hashtag fi"></i><input type="text" name="account_number" placeholder="03xxxxxxxxx" required></div>
                    </div>
                    <div class="field-grp">
                        <label>Amount</label>
                        <div class="field-wrap amt-wrap"><span class="fpre">Rs.</span><input type="number" name="amount" min="1" required></div>
                    </div>
                    <button type="submit" class="btn-nova mt-3">Send Now</button>
                </form>
            </div>
        </div>

        <div id="billModal" class="moverlay" style="display:none">
            <div class="msheet">
                <div class="mdrag"></div>
                <div class="mhdr"><h6>Pay Utility Bill</h6><button class="mx" onclick="closeModal('billModal')">×</button></div>
                <form action="{{ route('bill.process') }}" method="POST">
                    @csrf
                    <div class="bill-grid mb-3">
                        <label class="bill-tile"><input type="radio" name="bill_type" value="Electricity" checked style="display:none"><i class="fa-solid fa-bolt"></i><span>Electricity</span></label>
                        <label class="bill-tile"><input type="radio" name="bill_type" value="Gas" style="display:none"><i class="fa-solid fa-fire"></i><span>Gas</span></label>
                    </div>
                    <div class="field-grp">
                        <label>Consumer Reference</label>
                        <div class="field-wrap"><i class="fa-solid fa-barcode fi"></i><input type="text" name="reference_id" placeholder="14-digit No." required></div>
                    </div>
                    <div class="field-grp">
                        <label>Amount</label>
                        <div class="field-wrap amt-wrap"><span class="fpre">Rs.</span><input type="number" name="amount" min="1" required></div>
                    </div>
                    <button type="submit" class="btn-nova mt-3">Pay Bill Now</button>
                </form>
            </div>
        </div>

        <div id="loadModal" class="moverlay" style="display:none">
            <div class="msheet">
                <div class="mdrag"></div>
                <div class="mhdr"><h6>Mobile Load</h6><button class="mx" onclick="closeModal('loadModal')">×</button></div>
                <form action="{{ route('load.process') }}" method="POST">
                    @csrf
                    <div class="net-grid mb-3">
                        <label class="net-tile"><input type="radio" name="network" value="Jazz" checked style="display:none">Jazz</label>
                        <label class="net-tile"><input type="radio" name="network" value="Zong" style="display:none">Zong</label>
                    </div>
                    <div class="field-grp">
                        <label>Mobile Number</label>
                        <div class="field-wrap"><i class="fa-solid fa-mobile-screen fi"></i><input type="tel" name="phone" placeholder="03xxxxxxxxx" maxlength="11" required></div>
                    </div>
                    <div class="field-grp">
                        <label>Amount</label>
                        <div class="field-wrap amt-wrap"><span class="fpre">Rs.</span><input type="number" name="amount" min="50" required></div>
                    </div>
                    <button type="submit" class="btn-nova mt-3">Recharge Now</button>
                </form>
            </div>
        </div>

        <div id="toast" class="toast-msg @if(session('success')) show success @elseif($errors->any()) show error @endif">
            @if(session('success')) {{ session('success') }}
            @elseif($errors->any()) {{ $errors->first() }}
            @endif
        </div>