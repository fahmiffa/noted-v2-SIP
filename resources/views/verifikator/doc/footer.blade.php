Saran dan Masukkan Lain :
{!! $head->saran !!} 
  <table style="width:100%">
      <tr>
          <td width="40%" style="border:none">
          </td>
          <td width="60%" style="border:none">
              <p style="text-align:center;">Slawi, {{ dateID($head->created_at) }}</p>
              @if ($head->grant > 0)
                  <center><img src="data:image/png;base64, {{ $qrCode }}" width="15%"></center>
              @else
              <br><br><br>
              @endif
              <p style="text-align:center">DPUPR Kabupaten Tegal</p>
          </td>
      </tr>
  </table>
