
import {chromium} from '@playwright/test';
import {readFile,writeFile} from 'node:fs/promises';
import assert from 'node:assert/strict';
const base=process.env.QA_URL || 'http://127.0.0.1:8013';
const browser=await chromium.launch({channel:'chrome',headless:true});
const page=await browser.newPage({viewport:{width:1200,height:630}});
await page.goto(base+'/');
await page.setContent(await readFile('qa/brand-share.html','utf8'));
await page.evaluate(()=>document.fonts.ready);
await page.waitForFunction(()=>[...document.images].every(i=>i.complete));
assert.equal(await page.evaluate(()=>document.documentElement.scrollWidth),1200);
await page.screenshot({path:'public/images/brand-share.png'});
await page.setViewportSize({width:390,height:844});
await page.goto(base+'/');
const trigger=page.locator('.float-toggle');
const modal=page.locator('dialog');
let posts=0;page.on('request',r=>{if(r.method()==='POST')posts++;});
await trigger.click();
await page.locator('#consultation-name').fill('نمونه');
await page.locator('#consultation-phone').fill('۰۹۱۲۱۲۳۴۵۶۷');
await modal.locator('[type=submit]').click();
assert.equal(await modal.evaluate(el=>el.classList.contains('is-submitting')),true);
await page.waitForTimeout(150);
await page.keyboard.press('Escape');
await page.waitForFunction(()=>!document.querySelector('dialog').open);
await trigger.click();
await page.waitForTimeout(1100);
assert.equal(await modal.evaluate(el=>el.classList.contains('is-complete')),false);
await page.locator('#consultation-name').fill('نمونه');
await page.locator('#consultation-phone').fill('09121234567');
const start=Date.now();
await modal.locator('[type=submit]').click();
await page.waitForFunction(()=>!document.querySelector('dialog').open);
const duration=Date.now()-start;
assert.ok(duration>=1700&&duration<2400,String(duration));
assert.equal(posts,0);
assert.equal(await trigger.evaluate(el=>el===document.activeElement),true);
await page.locator('[data-theme-toggle]').click();
await page.waitForTimeout(850);
const theme=await page.evaluate(()=>document.documentElement.dataset.theme);
await page.reload();assert.equal(await page.evaluate(()=>document.documentElement.dataset.theme),theme);
await page.screenshot({path:'qa/screenshots/home-mobile-viewport.png'});
await page.setViewportSize({width:1440,height:1000});
await page.screenshot({path:'qa/screenshots/home-desktop-viewport.png'});
await page.locator('#product').scrollIntoViewIfNeeded();
await page.locator('#product').screenshot({path:'qa/screenshots/product-desktop.png'});
// Public destinations and all feature anchors.
const paths=['/','/features','/pricing','/about','/contact'];
for(const path of paths){
 await page.goto(base+path);
 const hrefs=await page.locator('a[href]').evaluateAll(links=>links.map(a=>a.href));
 for(const href of hrefs){
  const url=new URL(href);
  if(url.origin!==base || url.protocol!=='http:')continue;
  assert.ok(paths.includes(url.pathname),'Unexpected destination '+href);
  if(url.hash){
   const response=await page.request.get(href);
   assert.ok((await response.text()).includes('id="'+decodeURIComponent(url.hash.slice(1))+'"'),'Missing anchor '+href);
  }
 }
}
const sitemap=await page.request.get(base+'/sitemap.xml');
assert.equal(sitemap.status(),200);
const xml=await sitemap.text();
for(const path of paths)assert.ok(xml.includes('<loc>')&&xml.includes(path==='/'?'/</loc>':path+'</loc>'));
const llms=await page.request.get(base+'/llms.txt');assert.equal(llms.status(),200);
const robots=await page.request.get(base+'/robots.txt');assert.equal(robots.status(),200);
await writeFile('qa/motion-results.json',JSON.stringify({durationMs:duration,postRequests:posts,themePersistence:true,anchors:true,sitemap:true},null,2));
await browser.close();
console.log('Normal motion, interruption, links and SEO passed; demo sequence '+duration+' ms');
