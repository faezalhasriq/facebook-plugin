{*
/*
 * Copyright (c) 2014-2015 SugarCRM Inc.  This product is licensed by SugarCRM
 * pursuant to the terms of the End User License Agreement available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/10_Marketo/
 */
*}
<br/>
{if !empty($connector_language.LBL_LICENSING_INFO)}
    {$connector_language.LBL_LICENSING_INFO}
{/if}
<br/>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
    {if !empty($properties)}
        {foreach from=$properties key=name item=value}
            {assign var=placeholder value=$name|upper|cat:"_PLACEHOLDER"}
            <tr>
                <td class="dataLabel" width="35%">
                    {$connector_language[$name]}:&nbsp;
                    {if isset($required_properties[$name])}
                        <span class="required">*</span>
                    {/if}
                </td>
                <td class="dataLabel" width="65%">
                    {if "$name" == "records_to_download" || "$name" == "assigned_user_id" || "$name" == "enabled" || "$name" == "maximum_download"}
                    <select id="{$source_id}_{$name}" name="{$source_id}_{$name}">
                        {$mkto[$name]}
                    </select>
                    {elseif "$name" == "filters"}
                    <select id="{$source_id}_{$name}[]" name="{$source_id}_{$name}[]" multiple size="10">
                        {$filter}
                    </select>
                    {else}
                    <input type="text" id="{$source_id}_{$name}" name="{$source_id}_{$name}" size="75" value="{$value}"
                           placeholder="{$connector_language[$placeholder]}">
                </td>
                {/if}
                </td>
            </tr>
        {/foreach}
        {if $hasTestingEnabled}
            <tr>
                <td class="dataLabel" colspan="2">
                    <input id="{$source_id}_test_button" type="button" class="button" value="  {$mod.LBL_TEST_SOURCE}  "
                           onclick="run_test('{$source_id}');">
                </td>
            </tr>
            <tr>
                <td class="dataLabel" colspan="2">
                    <span id="{$source_id}_result">&nbsp;</span>
                </td>
            </tr>
        {/if}
    {else}
        <tr>
            <td class="dataLabel" colspan="2">&nbsp;</td>
            <td class="dataLabel" colspan="2">{$mod.LBL_NO_PROPERTIES}</td>
        </tr>
    {/if}
</table>

<script type="text/javascript">
    {foreach from=$required_properties key=id item=label}
    addToValidate("ModifyProperties", "{$source_id}_{$id}", "alpha", true, "{$label}");
    {/foreach}
</script>
