<table style="margin:0; padding:0; border:0;" class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table style="margin:0; padding:0; border:0;" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="center">
                        <table style="margin:0; padding:0; border:0;" border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td style="display:flex; justify-content:center; align-items:center;">
                                    <a href="{{ $url }}" class="button button-{{ $color ?? 'primary' }}" target="_blank">{{ $slot }}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
