<!doctype html>
<html lang="en">
<head>
    <title>监控日报 --- {{ date('Y-m-d') }}</title>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
</head>
<body>
<div style="margin:0 auto">
    <div style="background-color:#f5f5f5;padding:20px 0">
        <div style="color:#333;margin:0 auto;padding:24px;max-width:700px;font-family:'Helvetica Neue',Helvetica,Arial,Sans-serif;font-size:13px;line-height:1.7;background-color:#fff">
            <h1 style="margin:0 0 6px 0;font-size:25px;font-weight:bold;letter-spacing:-1px">监控日报 --- {{ date('Y-m-d') }}</h1>

            <h3 style="margin:24px 0 12px 0;border-bottom:1px solid #e0e0e0;padding-bottom:6px;color:#555;font-size:16px">站点情况</h3>
            <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                所有站点可正常访问
            </h4>
            <p style="margin:0;font-size:13px;line-height:20px;padding-bottom:10px;border-bottom:1px dotted #eee"></p>
            <h3 style="margin:24px 0 12px 0;border-bottom:1px solid #e0e0e0;padding-bottom:6px;color:#555;font-size:16px">收益</h3>
            <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                <a style="font-size:14px;line-height:22px;font-weight:bold;text-decoration:none;color:#259;border:none;outline:none" href="https://content.zxzuan.com/admin/index" target="_blank">
                    昨日 { {{$yesterdayRevenue}} } / 本周 { {{ $weekRevenue }} } / 本月 { {{ $monthRevenue }} }
                </a>
                <small style="color: #4a79b7;">$</small>
            </h4>
            @foreach($latestRevenue as $revenue)
            <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                {{ $revenue->affManage->name }} : {{ $revenue->TrackerName }} | {{ $revenue->Money }} -- {{$revenue->VisitTime}}
            </h4>
            @endforeach
            <p style="margin:0;font-size:13px;line-height:20px;padding-bottom:10px;border-bottom:1px dotted #eee"></p>
            <h3 style="margin:24px 0 12px 0;border-bottom:1px solid #e0e0e0;padding-bottom:6px;color:#555;font-size:16px">网站更新率 <small style="color: #4a79b7;">三日更新</small></h3>
            <?php $i=0; ?>
            @foreach($reportMerCoupon as $item)
                @if($item->MerUpNum <200 )
                    <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                        {{ $item->SiteName }} : {{$item->MerUpNum}}
                    </h4>
                    <?php $i++; ?>
                @endif
            @endforeach
            @if( $i==0 )
                <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                    Nice Job , 网站更新均运行正常
                </h4>
            @endif
            <p style="margin:0;font-size:13px;line-height:20px;padding-bottom:10px;border-bottom:1px dotted #eee"></p>
            <h3 style="margin:24px 0 12px 0;border-bottom:1px solid #e0e0e0;padding-bottom:6px;color:#555;font-size:16px">内容更新率 <small style="color: #4a79b7;">三日更新SALE/CODE</small></h3>
            <?php $i=0; ?>
            @foreach($reportCouponNum as $item)
                @if($item->couponNum <50 or $item->codeNum <20)
                    <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                        {{ $item->competitor->Url }} : {{$item->couponNum}} | {{$item->codeNum}}
                    </h4>
                    <?php $i++; ?>
                @endif
            @endforeach
            @if( $i==0 )
                <h4 style="margin:0;margin-bottom:6px;margin-top:6px">
                    Nice Job , 内容更新均运行正常
                </h4>
            @endif
        </div>
    </div>
</div>
<table width="100%" cellspacing="0" cellpadding="10">
    <tr>
        <td align="Center" bgColor="#f1f1f1">
            <div>
                <div id="txtHolder-4" class="txtEditorClass" style="color: #5d5d5d; font-size: 11px; font-family: 'Arial';"><a href="https://zxzuan.com/">ZXZUAN.COM</a></div>
            </div>
        </td>
    </tr>
</table>
</body>
</html>

