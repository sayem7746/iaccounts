<?php

/* //view_unpost_invoice
select a.ID as invoiceID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,a.supplierID,
b.itemID, b.itemName, b.amountExcludedtax, b.taxid, b.taxamount, 
(select inventoriesID from item where id=b.itemID) as drAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crAccountID,
(select taxAccount from tax_master where id=b.taxID) as drTaxAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crTaxAccountID
from comp_supplier_invoice a,
comp_supplier_invoice_detail b
where a.id = b.invoiceid
and a.updateable = 1
and a.is_delete =0 
union 
select a.ID as invoiceID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,a.supplierID,
null, b.itemname, b.amountExcludedtax, b.taxid, b.taxamount, 
b.accountNoID as drAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crAccountID,
(select taxAccount from tax_master where id=b.taxID) as drTaxAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crTaxAccountID
from comp_supplier_invoice a,
comp_supplier_invoice_charges b
where a.id = b.invoiceid
and a.updateable = 1
and a.is_delete =0 

//view_unpost_DEBITNOTE
select a.ID as debitnoteID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,
a.companyID,a.supplierID, c.supplierInvoiceNo,
b.itemID, b.itemName, b.amountExcludedtax, b.taxid, b.taxamount,
(select linkedAPAccountID from supplier where id=a.supplierID) as drAccountID,
(select inventoriesID from item where id=b.itemID) as crAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as drTaxAccountID,
(select taxAccount from tax_master where id=b.taxID) as crTaxAccountID
from comp_supplier_debitnote a,
comp_supplier_debitnote_detail b,
comp_supplier_invoice c
where a.id = b.debitnoteID
and a.supplierInvoiceID = c.ID
and a.updateable = 1
and a.is_delete =0 

//view_unpost_creDITNOTE
select a.ID as creditnoteID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,
a.companyID,a.supplierID, c.supplierInvoiceNo,
b.itemID, b.itemName, b.amountExcludedtax, b.taxid, b.taxamount,
(select inventoriesID from item where id=b.itemID) as drAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crAccountID,
(select taxAccount from tax_master where id=b.taxID) as drTaxAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as crTaxAccountID
from comp_supplier_creditnote a,
comp_supplier_creditnote_detail b,
comp_supplier_invoice c
where a.id = b.creditnoteID 
and a.supplierInvoiceID = c.ID
and a.updateable = 1
and a.is_delete =0 

//issue : payment tiada confirmation. terus post on save. 
//view_unpost_payment
//amountPaid => cr bank = acctNo dlm payment skrin
//bank charges => dr bank charges dlm sistem general setup
//amountApplied - discount => dr ap linkedAPacctountid dlm table supplier
//discount => dr ap
//discount => cr other income (discount rec) dlm sistem general setup

select a.ID as paymentID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,a.supplierID, null as purchaseInvoiceID,
null as paymentDetailID, null as supplierInvoiceNo, 
a.amountPaid as amtPaid_amtAppl, a.bankCharges as discount_bankCharges, 
null as drAccountID,
a.accountID as crAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'bankchargesAccount') as drDiscountAccountID,
null as crDiscountAccountID
from comp_payment a
where a.updateable = 1
and a.is_delete =0 
union
select a.ID as paymentID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,a.supplierID, b.purchaseInvoiceID,
b.ID as paymentDetailID, c.supplierInvoiceNo,  
b.amountApplied - b.discount as amtPaid_amtAppl, b.discount as discount_bankCharges,
(select linkedAPAccountID from supplier where id=a.supplierID) as drAccountID,
null as crAccountID,
(select linkedAPAccountID from supplier where id=a.supplierID) as drDiscountAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payDisc') as crDiscountAccountID
from comp_payment a,
comp_payment_detail b,
comp_supplier_invoice c
where a.id = b.paymentID
and c.id = b.purchaseInvoiceID 
and a.updateable = 1
and a.is_delete =0 

//view unpost other payment 
select a.ID as paymentID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,null as supplierID, null as purchaseInvoiceID,
null as paymentDetailID, null as supplierInvoiceNo, 
a.amountPaid as amtPaid_amtAppl, a.bankCharges as discount_bankCharges, 
null as drAccountID,
a.accountID as crAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'bankchargesAccount') as drDiscountAccountID,
null as crDiscountAccountID
from comp_payment_others a
where a.updateable = 1
and a.is_delete =0 
union
select a.ID as paymentID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,null as supplierID, null as purchaseInvoiceID,
b.ID as paymentDetailID, null as supplierInvoiceNo,  
b.amountIncludedTax  as amtPaid_amtAppl, null as discount_bankCharges,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payAcct') as drAccountID,
null as crAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payAcct') as drDiscountAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payDisc') as crDiscountAccountID
from comp_payment_others a,
comp_payment_others_with_item b
where a.id = b.otherPaymentID
and a.updateable = 1
and a.is_delete =0 
union
select a.ID as paymentID, concat(concat(concat(a.formNo,'['),lpad(a.id,8,'0')),']') as formNo ,a.companyID,null as supplierID, null as purchaseInvoiceID,
b.ID as paymentDetailID, null as supplierInvoiceNo,  
b.amountIncludedTax as amtPaid_amtAppl, null as discount_bankCharges,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payAcct') as drAccountID,
null as crAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payAcct') as drDiscountAccountID,
(select accountID from comp_control_acct_setup where companyID = a.companyID and accountCode = 'payDisc') as crDiscountAccountID
from comp_payment_others a,
comp_payment_others_without_item b
where a.id = b.otherPaymentID
and a.updateable = 1
and a.is_delete =0 
//view unpost other payment without item



//view supplier statement
select ID, ID as parent, companyID, supplierID, 
invoiceDate as transDate,supplierInvoiceNo as refNo, 
concat(concat(concat(formNo,'['),lpad(id,8,'0')),']') as formNo,
totalAmount as dr, null as cr, 1 as seq
from comp_supplier_invoice
union
select ID, supplierInvoiceID as parent, companyID, supplierID, 
debitnotedate  as transDate, null as refno, 
concat(concat(concat(formNo,'['),lpad(id,8,'0')),']') as formNo, 
null as dr, totalamount as cr, 2 as seq
from comp_supplier_debitnote
union
select ID, supplierInvoiceID as parent, companyID, supplierID, 
creditnotedate as transDate, null as refno, 
concat(concat(concat(formNo,'['),lpad(id,8,'0')),']') as formNo, 
totalamount as dr, null as cr, 3 as seq
from comp_supplier_creditnote
union
select a.ID, a.purchaseInvoiceID as parent, b.companyID, b.supplierID, 
b.paymentDate as transDate, b.referenceNo as refNo, 
concat(concat(concat(b.formNo,'['),lpad(b.id,8,'0')),']') as formNo,  
null as dr, a.amountApplied as cr, 4 as seq
from comp_payment_detail a, comp_payment b
where a.paymentID = b.id
union
select a.ID, a.purchaseInvoiceID as parent, b.companyID, b.supplierID, 
b.paymentDate as transDate, 'Discount' as refNo, 
concat(concat(concat(b.formNo,'['),lpad(b.id,8,'0')),']') as formNo,  
null as dr, a.discount as cr, 5 as seq
from comp_payment_detail a, comp_payment b
where a.paymentID = b.id


//view supplier aging
select a.id as supplierID, (select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=0) as current,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=1) as 1month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=2) as 2month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=3) as 3month,
(select sum(totalPayable)  from comp_supplier_invoice  where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=4) as 4month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=5) as 5month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=6) as 6month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=7) as 7month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=8) as 8month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=9) as 9month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=10) as 10month,
(select sum(totalPayable)  from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())>10) as 11month
from supplier a

//select id, supplierinvoiceNo, invoicedate,TIMESTAMPDIFF(MONTH,invoiceDate,now()) 
from comp_supplier_invoice
//select a.id, (select sum(totalPayable) from comp_supplier_invoice where companyID=a.companyID and supplierID = a.ID and TIMESTAMPDIFF(MONTH,invoiceDate,now())=0) as current from supplier a
//select period_diff(date_format(now(), '%Y%m'), date_format(time, '%Y%m')) as months from your_table;
//SELECT TIMESTAMPDIFF(MONTH, '2012-05-05', '2012-06-04')
*/
?>