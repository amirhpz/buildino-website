
import { chromium } from '@playwright/test';
import {writeFile} from 'node:fs/promises';
import assert from 'node:assert/strict';
const browser=await chromium.launch({channel:'chrome'});
const page=await browser.newPage({viewport:{width:390,height:844}});
const errors=[];page.on('pageerror',e=>errors.push(e.message));
const rows=[];
for(const path of ['/','/features','/pricing','/about','/contact']){
 const response=await page.goto('http://127.0.0.1:8015'+path);assert.equal(response.status(),200);
 await page.evaluate(()=>document.querySelectorAll('img').forEach(i=>i.loading='eager'));
 await page.waitForFunction(()=>[...document.images].every(i=>i.complete));
 assert.equal(await page.locator('h1').count(),1);
 assert.deepEqual(await page.evaluate(()=>[...document.images].filter(i=>!i.naturalWidth).map(i=>i.src)),[]);
 assert.equal(await page.locator('link[rel=canonical]').getAttribute('href'),'http://127.0.0.1:8015'+path);
 await page.locator('.float-toggle').click();assert.equal(await page.locator('dialog').evaluate(e=>e.open),true);
 await page.keyboard.press('Escape');await page.waitForFunction(()=>!document.querySelector('dialog').open);
 rows.push({path,status:response.status(),pass:true});
}
const notfound=await page.goto('http://127.0.0.1:8015/test-missing-page');assert.equal(notfound.status(),404);
assert.deepEqual(errors,[]);
await writeFile('qa/deployment-smoke.json',JSON.stringify({pages:rows,status404:404,javascriptErrors:errors},null,2));
await browser.close();console.log('Production bundle: five pages, images, modal and 404 passed');
