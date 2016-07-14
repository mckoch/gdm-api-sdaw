drop table if exists stats_okzf;
create table stats_okzf

select STA.StatOrtskz as okzf, 
stat_ew_mw.Ort,
count(FRE_FREIE_TAFELN.Standortnr),
count(distinct STA.Standortnr),
stat_ew_mw.Gesamt,
stat_flaechen.qkm,
avg(STA.Preis),
avg(STA.Leistungswert1)

from FRE_FREIE_TAFELN, STA

left join `stat_ew_mw` 
on stat_ew_mw.StatOrtsKzf = STA.StatOrtskz
left join `stat_flaechen` 
on stat_flaechen.StatOrtsKzf = stat_ew_mw.StatOrtsKzf 


where STA.Standortnr = FRE_FREIE_TAFELN.Standortnr

group by STA.StatOrtskz
;